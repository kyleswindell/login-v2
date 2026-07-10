<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Account/Http/Controllers/AccountController.php
| Purpose: Provides Account module package behavior.
|--------------------------------------------------------------------------
*/

namespace App\Modules\Account\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Account\Models\UserContactEmail;
use App\Modules\Account\Support\AccountPageTabs;
use App\Modules\Auth\Notifications\Types as AuthNotificationTypes;
use App\Modules\Auth\Services\Mfa\MfaStepUpGuard;
use App\Modules\Auth\Services\Password\LocalPasswordPolicy;
use App\Modules\Notifications\Services\Notifier;
use App\Support\InternalPhoneFormatter;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function __construct(
        private readonly MfaStepUpGuard $mfaStepUpGuard,
        private readonly Notifier $notifier,
    ) {}

    public function index(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();

        return view('account::index', [
            'accountTabs' => AccountPageTabs::items(),
            'contactEmails' => $user->contactEmails()
                ->orderBy('email')
                ->get(),
            'profileImageUrl' => $this->profileImageUrl($user),
            'user' => $user,
        ]);
    }

    public function security(Request $request): View
    {
        /** @var User $user */
        $user = $request->user();

        return view('account::security', [
            'accountTabs' => AccountPageTabs::items(),
            'hasMfa' => $user->hasConfirmedTotpMfa(),
            'user' => $user,
        ]);
    }

    public function settings(): RedirectResponse
    {
        return redirect()->route('platform.account.index');
    }

    public function updateProfilePhoto(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('profilePhoto', [
            'profile_photo' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        /** @var User $user */
        $user = $request->user();
        $photo = $validated['profile_photo'];

        $this->deleteStoredProfilePhoto($user);

        $user->forceFill([
            'profile_image_path' => $photo->store("profile-photos/{$user->id}", 'public'),
        ])->save();

        return redirect()
            ->route('platform.account.index')
            ->with('success', 'Profile photo updated.');
    }

    public function removeProfilePhoto(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        $this->deleteStoredProfilePhoto($user);

        $user->forceFill([
            'profile_image_path' => null,
        ])->save();

        return redirect()
            ->route('platform.account.index')
            ->with('success', 'Profile photo removed.');
    }

    public function updateDetails(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('accountDetails', [
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
        ]);

        /** @var User $user */
        $user = $request->user();

        $user->forceFill([
            'first_name' => $validated['first_name'] ?? null,
            'last_name' => $validated['last_name'] ?? null,
            'name' => $validated['name'],
            'phone' => InternalPhoneFormatter::normalize($validated['phone'] ?? null),
        ])->save();

        return redirect()
            ->route('platform.account.index')
            ->with('success', 'Account details updated.');
    }

    public function storeContactEmail(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('contactEmail', [
            'email' => ['required', 'email', 'max:255'],
            'label' => ['nullable', 'string', 'max:80'],
        ]);

        /** @var User $user */
        $user = $request->user();
        $normalizedEmail = $this->normalizeEmail($validated['email']);

        if ($this->isSignInEmail($normalizedEmail)) {
            return back()->withErrors([
                'email' => 'Contact emails must be separate from sign-in email addresses.',
            ], 'contactEmail')->withInput();
        }

        if (UserContactEmail::query()->where('normalized_email', $normalizedEmail)->exists()) {
            return back()->withErrors([
                'email' => 'This contact email is already in use.',
            ], 'contactEmail')->withInput();
        }

        $user->contactEmails()->create([
            'email' => trim($validated['email']),
            'normalized_email' => $normalizedEmail,
            'label' => $validated['label'] ?? null,
        ]);

        return redirect()
            ->route('platform.account.index')
            ->with('success', 'Contact email added.');
    }

    public function destroyContactEmail(Request $request, UserContactEmail $contactEmail): RedirectResponse
    {
        abort_unless((int) $contactEmail->user_id === (int) $request->user()->id, 404);

        $contactEmail->delete();

        return redirect()
            ->route('platform.account.index')
            ->with('success', 'Contact email removed.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('passwordUpdate', [
            'current_password' => ['required', 'current_password'],
            'new_password' => [
                'required',
                'string',
                'confirmed',
                ...LocalPasswordPolicy::rulesForUser($request->user()),
            ],
        ]);

        /** @var User $user */
        $user = $request->user();

        if ($this->mfaStepUpGuard->requiresEnrollment($user)) {
            return redirect()
                ->route('platform.account.mfa.enroll')
                ->withErrors(['code' => 'MFA enrollment is required before changing account security settings.']);
        }

        if ($this->mfaStepUpGuard->requiresFreshMfa($request, $user)) {
            return $this->mfaStepUpGuard->redirectToChallenge(
                $request,
                route('platform.account.security', absolute: false),
                'Verify MFA before changing account security settings.',
            );
        }

        $user->forceFill([
            'password' => $validated['new_password'],
        ])->save();

        $this->notifier->send(
            type: AuthNotificationTypes::PASSWORD_CHANGED,
            recipient: $user,
            actor: $user,
            subject: $user,
        );

        $this->mfaStepUpGuard->clearFreshMfa($request);

        return redirect()
            ->route('platform.account.security')
            ->with('success', 'Password updated.');
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($request->user()->id)],
            'phone' => ['nullable', 'string', 'max:50'],
            'current_password' => ['nullable', 'required_with:new_password', 'current_password'],
            'new_password' => [
                'nullable',
                'string',
                'confirmed',
                ...LocalPasswordPolicy::rulesForUser($request->user()),
            ],
        ]);

        /** @var User $user */
        $user = $request->user();
        $requiresSecurityStepUp = $this->requiresFreshMfaForSettingsChange($user, $validated);

        if ($requiresSecurityStepUp) {
            if ($this->mfaStepUpGuard->requiresEnrollment($user)) {
                return redirect()
                    ->route('platform.account.mfa.enroll')
                    ->withErrors(['code' => 'MFA enrollment is required before changing account security settings.']);
            }

            if ($this->mfaStepUpGuard->requiresFreshMfa($request, $user)) {
                return $this->mfaStepUpGuard->redirectToChallenge(
                    $request,
                    route('platform.account.index', absolute: false),
                    'Verify MFA before changing account security settings.',
                );
            }
        }

        $user->forceFill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => InternalPhoneFormatter::normalize($validated['phone'] ?? null),
        ])->save();

        if (! empty($validated['new_password'])) {
            $user->forceFill([
                'password' => $validated['new_password'],
            ])->save();

            $this->notifier->send(
                type: AuthNotificationTypes::PASSWORD_CHANGED,
                recipient: $user,
                actor: $user,
                subject: $user,
            );
        }

        if ($requiresSecurityStepUp) {
            $this->mfaStepUpGuard->clearFreshMfa($request);
        }

        return redirect()
            ->route('platform.account.index')
            ->with('success', 'Account settings updated.');
    }

    /**
     * @param array<string, mixed> $validated
     */
    private function requiresFreshMfaForSettingsChange(User $user, array $validated): bool
    {
        return (string) $validated['email'] !== (string) $user->email
            || filled($validated['new_password'] ?? null);
    }

    private function profileImageUrl(User $user): ?string
    {
        if (! filled($user->profile_image_path)) {
            return null;
        }

        return Storage::disk('public')->url($user->profile_image_path);
    }

    private function deleteStoredProfilePhoto(User $user): void
    {
        if (filled($user->profile_image_path)) {
            Storage::disk('public')->delete($user->profile_image_path);
        }
    }

    private function normalizeEmail(string $email): string
    {
        return mb_strtolower(trim($email));
    }

    private function isSignInEmail(string $normalizedEmail): bool
    {
        return User::query()
            ->whereRaw('LOWER(email) = ?', [$normalizedEmail])
            ->exists();
    }
}
