<?php

namespace Tests\Feature\Platform;

use App\Models\PlatformAuditLog;
use App\Models\User;
use App\Modules\Account\Models\UserContactEmail;
use App\Modules\Auth\Models\UserMfaMethod;
use App\Modules\Auth\Notifications\Types as AuthNotificationTypes;
use App\Modules\Notifications\Models\UserNotificationPreference;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use PragmaRX\Google2FA\Google2FA;
use Tests\TestCase;

class PlatformAccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_users_can_view_account_surfaces(): void
    {
        $user = User::factory()->create([
            'name' => 'Alex Operator',
            'email' => 'alex@example.com',
        ]);

        $this->actingAs($user);

        $this->get('/account')
            ->assertOk()
            ->assertSee('Profile')
            ->assertSee('Contact methods')
            ->assertSee('Additional contact emails')
            ->assertSee('data-account-profile-tabs', false)
            ->assertSee('data-ui-tabs-orientation="vertical"', false)
            ->assertSee('data-ui-shell-page-tabs', false)
            ->assertSee('href="'.url('/account/security').'"', false)
            ->assertSee('href="'.url('/account/notifications').'"', false)
            ->assertSee('href="'.url('/account/preferences').'"', false)
            ->assertDontSee('href="'.url('/account/settings').'"', false)
            ->assertSee('data-ui-icon-button', false)
            ->assertSee('aria-label="Edit profile"', false)
            ->assertSee('role="tooltip"', false)
            ->assertDontSee('Account security')
            ->assertDontSee('Update password')
            ->assertDontSee('Multi-factor authentication');

        $this->get('/account/security')
            ->assertOk()
            ->assertSee('Security')
            ->assertSee('Overview')
            ->assertSee('Password')
            ->assertSee('Multi-factor authentication')
            ->assertSee('data-account-security-tabs', false)
            ->assertSee('data-ui-tabs-orientation="vertical"', false)
            ->assertSee('aria-label="Edit password"', false)
            ->assertSee('role="tooltip"', false);

        $this->get('/account/settings')
            ->assertRedirect('/account');

        $this->get('/account/preferences')
            ->assertOk()
            ->assertSee('Preferences')
            ->assertSee('Personal defaults')
            ->assertSee('data-account-preferences-tabs', false)
            ->assertSee('data-ui-tabs-orientation="vertical"', false)
            ->assertSee('aria-label="Edit preferences"', false)
            ->assertSee('data-ui-component="searchable-select"', false)
            ->assertSee('data-ui-searchable-select-trigger', false);

        $this->get('/account/notifications')
            ->assertOk()
            ->assertSee('Notifications')
            ->assertSee('Delivery preferences')
            ->assertSee('data-account-notifications-tabs', false)
            ->assertSee('data-ui-tabs-orientation="vertical"', false)
            ->assertSee('aria-label="Edit notification preferences"', false)
            ->assertSee('data-account-notification-preferences-form', false)
            ->assertDontSee('In-app notifications')
            ->assertDontSee('name="in_app_enabled"', false);
    }

    public function test_account_details_can_be_updated(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $this->actingAs($user)
            ->patch('/account/details', [
                'first_name' => 'Updated',
                'last_name' => 'Operator',
                'name' => 'Updated Name',
                'phone' => '5555555555',
            ])
            ->assertRedirect('/account');

        $user->refresh();

        $this->assertSame('Updated', $user->first_name);
        $this->assertSame('Operator', $user->last_name);
        $this->assertSame('Updated Name', $user->name);
        $this->assertSame('(555) 555-5555', $user->phone);
    }

    public function test_profile_photo_can_be_uploaded_and_removed(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $this->actingAs($user)
            ->patch('/account/profile-photo', [
                'profile_photo' => UploadedFile::fake()->image('avatar.png', 128, 128),
            ])
            ->assertRedirect('/account');

        $user->refresh();

        $this->assertNotNull($user->profile_image_path);
        Storage::disk('public')->assertExists($user->profile_image_path);

        $storedPath = $user->profile_image_path;

        $this->actingAs($user)
            ->delete('/account/profile-photo')
            ->assertRedirect('/account');

        $this->assertNull($user->fresh()->profile_image_path);
        Storage::disk('public')->assertMissing($storedPath);
    }

    public function test_contact_only_emails_can_be_added_removed_and_do_not_authenticate(): void
    {
        $user = User::factory()->create([
            'email' => 'primary@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->actingAs($user)
            ->post('/account/contact-emails', [
                'email' => 'alternate@example.com',
                'label' => 'Billing',
            ])
            ->assertRedirect('/account');

        $contactEmail = UserContactEmail::query()->firstOrFail();

        $this->assertSame($user->id, $contactEmail->user_id);
        $this->assertSame('alternate@example.com', $contactEmail->normalized_email);
        $this->assertDatabaseMissing('users', ['email' => 'alternate@example.com']);

        $this->post('/logout')->assertRedirect('/login');

        $this->post('/login/identify', [
            'identifier' => 'alternate@example.com',
        ])->assertRedirect('/login/password');

        $this->from('/login/password')
            ->post('/login/password', ['password' => 'password'])
            ->assertRedirect('/login/password')
            ->assertSessionHasErrors(['password']);

        $this->assertGuest();

        $this->actingAs($user)
            ->delete("/account/contact-emails/{$contactEmail->id}")
            ->assertRedirect('/account');

        $this->assertDatabaseMissing('user_contact_emails', [
            'id' => $contactEmail->id,
        ]);
    }

    public function test_contact_only_email_cannot_duplicate_sign_in_email(): void
    {
        $user = User::factory()->create([
            'email' => 'primary@example.com',
        ]);

        $this->actingAs($user)
            ->post('/account/contact-emails', [
                'email' => 'primary@example.com',
                'label' => 'Duplicate',
            ])
            ->assertSessionHasErrors('email', null, 'contactEmail');

        $this->assertDatabaseCount('user_contact_emails', 0);
    }

    public function test_account_password_policy_rejects_common_and_contextual_passwords(): void
    {
        $user = User::factory()->create([
            'name' => 'Alex Operator',
            'email' => 'alex.operator@example.com',
            'password' => Hash::make('current-password'),
        ]);

        $this->actingAs($user)
            ->post('/account/password', [
                'current_password' => 'current-password',
                'new_password' => 'Password123!',
                'new_password_confirmation' => 'Password123!',
            ])->assertSessionHasErrors(['new_password']);

        $this->actingAs($user)
            ->post('/account/password', [
                'current_password' => 'current-password',
                'new_password' => 'AlexOperator2026!',
                'new_password_confirmation' => 'AlexOperator2026!',
            ])->assertSessionHasErrors(['new_password']);

        $this->assertTrue(Hash::check('current-password', $user->fresh()->password));
    }

    public function test_account_password_policy_accepts_sixty_four_character_passwords(): void
    {
        $user = User::factory()->create([
            'name' => 'Alex Operator',
            'email' => 'alex.operator@example.com',
            'password' => Hash::make('current-password'),
        ]);
        $longPassword = 'Long-Safe-Phrase-'.str_repeat('x', 47);

        $this->assertGreaterThanOrEqual(64, strlen($longPassword));

        $this->actingAs($user)
            ->post('/account/password', [
                'current_password' => 'current-password',
                'new_password' => $longPassword,
                'new_password_confirmation' => $longPassword,
            ])->assertRedirect('/account/security');

        $this->assertTrue(Hash::check($longPassword, $user->fresh()->password));
        $this->assertDatabaseHas('notifications', [
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'type_key' => AuthNotificationTypes::PASSWORD_CHANGED,
            'module_key' => 'auth',
        ]);

        $this->post('/logout')->assertRedirect('/login');

        $this->post('/login', [
            'email' => $user->email,
            'password' => $longPassword,
        ])->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);
    }

    public function test_breached_password_report_only_mode_allows_update_and_audits_detection(): void
    {
        $password = 'Breach-Report-Only-47!';
        $user = User::factory()->create([
            'name' => 'Alex Operator',
            'email' => 'alex.operator@example.com',
            'password' => Hash::make('current-password'),
        ]);

        $this->configureBreachedPasswordMode('report_only');
        $this->fakeBreachedPasswordResponse($password);

        $this->actingAs($user)
            ->post('/account/password', [
                'current_password' => 'current-password',
                'new_password' => $password,
                'new_password_confirmation' => $password,
            ])->assertRedirect();

        $this->assertTrue(Hash::check($password, $user->fresh()->password));

        $log = PlatformAuditLog::query()
            ->where('event_type', 'auth.password_breached_detected')
            ->firstOrFail();

        $this->assertSame($user->id, $log->actor_user_id);
        $this->assertSame('report_only', $log->metadata['mode']);
        $this->assertSame('hibp', $log->metadata['provider']);
        $this->assertTrue($log->metadata['breach_count_available']);
        $this->assertStringNotContainsString($password, json_encode($log->metadata));
    }

    public function test_breached_password_enforced_mode_rejects_update(): void
    {
        $password = 'Breach-Enforced-47!';
        $user = User::factory()->create([
            'name' => 'Alex Operator',
            'email' => 'alex.operator@example.com',
            'password' => Hash::make('current-password'),
        ]);

        $this->configureBreachedPasswordMode('enforced');
        $this->fakeBreachedPasswordResponse($password);

        $this->actingAs($user)
            ->post('/account/password', [
                'current_password' => 'current-password',
                'new_password' => $password,
                'new_password_confirmation' => $password,
            ])->assertSessionHasErrors(['new_password']);

        $this->assertTrue(Hash::check('current-password', $user->fresh()->password));

        $log = PlatformAuditLog::query()
            ->where('event_type', 'auth.password_breached_detected')
            ->firstOrFail();

        $this->assertSame('enforced', $log->metadata['mode']);
        $this->assertSame('failure', $log->result);
        $this->assertTrue($log->is_security_event);
        $this->assertStringNotContainsString($password, json_encode($log->metadata));
    }

    public function test_breached_password_enforced_mode_fails_closed_when_provider_is_unavailable(): void
    {
        $password = 'Provider-Unavailable-47!';
        $user = User::factory()->create([
            'name' => 'Alex Operator',
            'email' => 'alex.operator@example.com',
            'password' => Hash::make('current-password'),
        ]);

        $this->configureBreachedPasswordMode('enforced');
        $this->fakeBreachedPasswordUnavailableResponse($password);

        $this->actingAs($user)
            ->post('/account/password', [
                'current_password' => 'current-password',
                'new_password' => $password,
                'new_password_confirmation' => $password,
            ])->assertSessionHasErrors(['new_password']);

        $this->assertTrue(Hash::check('current-password', $user->fresh()->password));

        $log = PlatformAuditLog::query()
            ->where('event_type', 'auth.password_breach_check_failed')
            ->firstOrFail();

        $this->assertSame('enforced', $log->metadata['mode']);
        $this->assertSame('hibp', $log->metadata['provider']);
        $this->assertSame('provider_http_503', $log->metadata['failure_reason']);
        $this->assertTrue($log->metadata['fail_closed']);
        $this->assertStringNotContainsString($password, json_encode($log->metadata));
    }

    public function test_repeated_breached_password_detections_emit_suspicious_auth_detection(): void
    {
        $password = 'Repeated-Breach-47!';
        $currentPassword = 'current-password';
        $user = User::factory()->create([
            'name' => 'Alex Operator',
            'email' => 'alex.operator@example.com',
            'password' => Hash::make($currentPassword),
        ]);

        $this->configureBreachedPasswordMode('report_only');
        $this->fakeBreachedPasswordResponse($password);

        for ($attempt = 0; $attempt < 3; $attempt++) {
            $this->actingAs($user)
                ->post('/account/password', [
                    'current_password' => $currentPassword,
                    'new_password' => $password,
                    'new_password_confirmation' => $password,
                ])->assertRedirect();

            $currentPassword = $password;
        }

        $log = PlatformAuditLog::query()
            ->where('event_type', 'auth.suspicious_activity_detected')
            ->get()
            ->first(fn (PlatformAuditLog $log): bool => ($log->metadata['signal'] ?? null) === 'breached_password_repeated');

        $this->assertInstanceOf(PlatformAuditLog::class, $log);

        $metadata = $log->metadata;

        $this->assertSame(3, $metadata['threshold']);
        $this->assertSame(3, $metadata['event_count']);
        $this->assertSame($user->id, $metadata['user_id']);
        $this->assertSame(User::class, $log->subject_type);
        $this->assertSame((string) $user->id, $log->subject_id);
        $this->assertStringNotContainsString($password, json_encode($metadata));
        $this->assertStringNotContainsString(strtoupper(sha1($password)), json_encode($metadata));
    }

    public function test_account_settings_surface_uses_shared_phone_input_baseline(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/account')
            ->assertOk()
            ->assertSee('data-ui-phone-input', false)
            ->assertSee('placeholder="(555) 555-5555"', false);
    }

    public function test_account_suite_views_use_current_form_contracts(): void
    {
        $viewPaths = [
            'Modules/Account/resources/views/index.blade.php',
            'Modules/Account/resources/views/security.blade.php',
            'Modules/Account/resources/views/partials/profile/profile.blade.php',
            'Modules/Account/resources/views/partials/profile/contact-methods.blade.php',
            'Modules/Account/resources/views/partials/profile/modals.blade.php',
            'Modules/Account/resources/views/partials/security/overview.blade.php',
            'Modules/Account/resources/views/partials/security/password.blade.php',
            'Modules/Account/resources/views/partials/security/mfa.blade.php',
            'Modules/Account/resources/views/partials/security/password-modal.blade.php',
            'Modules/Preferences/resources/views/personal-defaults.blade.php',
            'Modules/Preferences/resources/views/partials/personal-defaults.blade.php',
            'Modules/Preferences/resources/views/partials/modals/edit-personal-defaults.blade.php',
            'Modules/Notifications/resources/views/account/preferences.blade.php',
            'Modules/Notifications/resources/views/account/partials/delivery-preferences.blade.php',
            'Modules/Notifications/resources/views/account/partials/modals/edit-delivery-preferences.blade.php',
        ];

        foreach ($viewPaths as $viewPath) {
            $source = file_get_contents(base_path($viewPath));

            $this->assertStringContainsString('x-ui.grid', $source, $viewPath);
            $this->assertStringNotContainsString('x-patterns.form-group', $source);
            $this->assertStringNotContainsString('x-patterns.form-actions-bar', $source);
            $this->assertStringNotContainsString('x-patterns.forms.dialog', $source);
            $this->assertStringNotContainsString('class="ui-input', $source);
            $this->assertStringNotContainsString('col-md-', $source);
            $this->assertStringNotContainsString('card ', $source);
        }

        $this->assertStringContainsString('x-ui.tabs', file_get_contents(base_path('Modules/Account/resources/views/index.blade.php')));
        $this->assertStringContainsString('x-ui.tabs', file_get_contents(base_path('Modules/Account/resources/views/security.blade.php')));
        $this->assertStringContainsString('x-ui.tabs', file_get_contents(base_path('Modules/Preferences/resources/views/personal-defaults.blade.php')));
        $this->assertStringContainsString('x-ui.tabs', file_get_contents(base_path('Modules/Notifications/resources/views/account/preferences.blade.php')));
        $this->assertStringContainsString('x-ui.modal', file_get_contents(base_path('Modules/Account/resources/views/partials/profile/modals.blade.php')));
        $this->assertStringContainsString('x-ui.modal', file_get_contents(base_path('Modules/Account/resources/views/partials/security/password-modal.blade.php')));
        $this->assertStringContainsString('x-ui.modal', file_get_contents(base_path('Modules/Preferences/resources/views/partials/modals/edit-personal-defaults.blade.php')));
        $this->assertStringContainsString('x-ui.modal', file_get_contents(base_path('Modules/Notifications/resources/views/account/partials/modals/edit-delivery-preferences.blade.php')));
    }

    public function test_account_edit_actions_render_icon_buttons_with_tooltips(): void
    {
        $user = User::factory()->create();

        $profile = $this->actingAs($user)->get('/account')->assertOk()->getContent();
        $security = $this->actingAs($user)->get('/account/security')->assertOk()->getContent();
        $preferences = $this->actingAs($user)->get('/account/preferences')->assertOk()->getContent();
        $notifications = $this->actingAs($user)->get('/account/notifications')->assertOk()->getContent();

        foreach ([
            [$profile, 'Edit profile'],
            [$profile, 'Edit profile photo'],
            [$profile, 'Edit contact details'],
            [$profile, 'Edit contact emails'],
            [$security, 'Edit password'],
            [$preferences, 'Edit preferences'],
            [$notifications, 'Edit notification preferences'],
        ] as [$content, $label]) {
            $this->assertStringContainsString('data-ui-icon-button', $content);
            $this->assertStringContainsString('aria-label="'.$label.'"', $content);
            $this->assertStringContainsString('role="tooltip"', $content);
            $this->assertStringContainsString($label, $content);
        }
    }

    public function test_authenticated_user_can_enroll_mfa_from_account_settings(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/account/mfa/enroll')
            ->assertOk()
            ->assertSee('Manual Key')
            ->assertSee('Authenticator Code');

        $method = $user->fresh()->totpMfaMethod()->firstOrFail();
        $code = (new Google2FA())->getCurrentOtp((string) $method->pending_secret);

        $this->actingAs($user)
            ->post('/account/mfa/enroll', [
                'code' => $code,
            ])->assertRedirect('/account/mfa/recovery-codes');

        $method->refresh();

        $this->assertNotNull($method->secret);
        $this->assertNull($method->pending_secret);
        $this->assertNotNull($method->confirmed_at);
        $this->assertSame(10, $user->fresh()->mfaRecoveryCodes()->count());

        $this->get('/account/mfa/recovery-codes')
            ->assertOk()
            ->assertSee('Save your recovery codes')
            ->assertSee('Each code can only be used once.')
            ->assertSee('Create New Codes')
            ->assertSee('Download')
            ->assertSee('download="mfa-recovery-codes.txt"', false)
            ->assertSee('data-mfa-recovery-codes-list', false)
            ->assertSee('data-mfa-recovery-codes-close', false)
            ->assertSee('data-mfa-recovery-codes-create', false)
            ->assertSee('data-mfa-recovery-codes-download', false);

        $this->get('/account/mfa/recovery-codes')
            ->assertRedirect('/account');

        $this->assertDatabaseHas('platform_audit_logs', [
            'event_type' => 'auth.mfa_enrolled',
            'actor_user_id' => $user->id,
            'is_security_event' => true,
        ]);
        $this->assertDatabaseHas('notifications', [
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'type_key' => AuthNotificationTypes::MFA_ENROLLED,
            'module_key' => 'auth',
        ]);
    }

    public function test_account_settings_shows_enabled_mfa_without_self_service_disable(): void
    {
        $user = User::factory()->create();

        UserMfaMethod::query()->create([
            'user_id' => $user->id,
            'type' => UserMfaMethod::TYPE_TOTP,
            'secret' => (new Google2FA())->generateSecretKey(),
            'confirmed_at' => now(),
        ]);

        $this->actingAs($user)
            ->get('/account/security')
            ->assertOk()
            ->assertSee('Enabled with authenticator app.')
            ->assertSee('Recovery codes')
            ->assertDontSee('Disable MFA');
    }

    public function test_account_preferences_can_be_updated(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/account/preferences', [
                'timezone' => 'America/New_York',
                'default_language' => 'en',
                'theme_preference' => 'light',
            ])
            ->assertRedirect();

        $user->refresh();

        $this->assertSame('America/New_York', $user->timezone);
        $this->assertSame('en', $user->default_language);
        $this->assertSame('light', $user->theme_preference);
    }

    public function test_account_notification_preferences_can_be_updated(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/account/notifications', [
                'email_enabled' => '1',
                'digest_frequency' => 'daily',
            ])
            ->assertRedirect();

        $preference = UserNotificationPreference::query()->where('user_id', $user->id)->firstOrFail();

        $this->assertTrue($preference->email_enabled);
        $this->assertSame('daily', $preference->digest_frequency);

        $this->actingAs($user)
            ->post('/account/notifications', [
                'email_enabled' => '0',
                'digest_frequency' => 'weekly',
            ])
            ->assertRedirect();

        $preference->refresh();

        $this->assertFalse($preference->email_enabled);
        $this->assertSame('weekly', $preference->digest_frequency);
    }

    public function test_header_account_dropdown_consumes_shared_action_and_menu_item_contracts(): void
    {
        $user = User::factory()->create([
            'theme_preference' => 'dark',
        ]);

        $response = $this->actingAs($user)
            ->get('/account')
            ->assertOk()
            ->assertSee('data-account-menu', false)
            ->assertSee('data-theme-mode-toggle', false)
            ->assertSee('data-ui-component="menu-item"', false)
            ->assertSee('data-ui-current="true"', false)
            ->assertSee('aria-current="true"', false)
            ->assertSee('ui-action-outline', false)
            ->assertSee('ui-action-danger', false)
            ->assertSee('ui-action-ghost', false)
            ->assertSee('Profile')
            ->assertSee('Security')
            ->assertSee('Preferences')
            ->assertDontSee('Account Settings');

        $content = $response->getContent();

        preg_match_all('/<button[^>]*data-theme-mode-toggle[^>]*>/', $content, $themeToggles);

        $this->assertCount(3, $themeToggles[0]);
        $this->assertSame(1, substr_count(implode("\n", $themeToggles[0]), 'data-ui-current="true"'));

        foreach ($themeToggles[0] as $themeToggle) {
            $this->assertStringContainsString('ui-action-ghost', $themeToggle);
            $this->assertStringNotContainsString('ui-action-outline', $themeToggle);
        }

        $this->assertStringContainsString('data-theme-mode="dark"', $content);
        $this->assertStringContainsString('aria-pressed="true"', $content);
        $this->assertStringNotContainsString('rounded-md px-2 py-2 text-xs font-semibold text-slate-300 transition hover:bg-slate-800 hover:text-white', $content);
        $this->assertStringNotContainsString('hover:bg-rose-500/10 hover:text-rose-100', $content);
    }

    public function test_account_preferences_reject_invalid_language_option(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/account/preferences', [
                'timezone' => 'America/New_York',
                'default_language' => 'invalid-language',
                'theme_preference' => 'light',
            ])
            ->assertSessionHasErrors(['default_language']);
    }

    private function configureBreachedPasswordMode(string $mode): void
    {
        config()->set('platform.security.passwords.breached.mode', $mode);
        config()->set('platform.security.passwords.breached.fail_closed', true);
        config()->set('platform.security.passwords.breached.hibp.cache_ttl_seconds', 0);
    }

    private function fakeBreachedPasswordResponse(string $password): void
    {
        [$prefix, $suffix] = $this->hibpHashParts($password);

        Http::fake([
            "https://api.pwnedpasswords.com/range/{$prefix}" => Http::response($suffix.":27\r\n00000000000000000000000000000000000:0\r\n"),
        ]);
    }

    private function fakeBreachedPasswordUnavailableResponse(string $password): void
    {
        [$prefix] = $this->hibpHashParts($password);

        Http::fake([
            "https://api.pwnedpasswords.com/range/{$prefix}" => Http::response('', 503),
        ]);
    }

    /**
     * @return array{0: string, 1: string}
     */
    private function hibpHashParts(string $password): array
    {
        $hash = strtoupper(sha1($password));

        return [substr($hash, 0, 5), substr($hash, 5)];
    }
}
