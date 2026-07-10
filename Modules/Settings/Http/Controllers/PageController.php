<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Settings/Http/Controllers/PageController.php
| Purpose: Handles Settings module page rendering and updates.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Settings\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Roles\Services\RoleCatalog;
use App\Modules\Settings\Navigation\SidebarBuilder;
use App\Modules\Settings\Services\SettingsPermissions;
use App\Modules\Settings\Services\Store;
use App\Platform\Logging\PlatformLogger;
use App\Support\InternalPhoneFormatter;
use App\Support\UiOptionCatalog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

final class PageController extends Controller
{
    public function __construct(
        private readonly Store $settings,
        private readonly PlatformLogger $logger,
    ) {}

    public function index(Request $request, SidebarBuilder $navigation): View
    {
        $this->authorize(SettingsPermissions::VIEW);

        return view('settings::index', [
            'settingsItems' => $navigation->landingItems($request->user(), $request->route()?->getName()),
        ]);
    }

    public function general(): View
    {
        $this->authorize(SettingsPermissions::VIEW);

        return view('settings::general', [
            'displayName' => $this->settings->get('general', 'display_name', config('app.name')),
            'timezone' => $this->settings->get('general', 'timezone', config('app.timezone')),
            'locale' => $this->settings->get('general', 'locale', config('app.locale')),
            'timezoneOptions' => UiOptionCatalog::timezoneOptions(),
            'localeOptions' => UiOptionCatalog::localeOptions(),
        ]);
    }

    public function updateGeneral(Request $request): RedirectResponse
    {
        $this->authorize(SettingsPermissions::UPDATE);

        $validated = $request->validate([
            'display_name' => ['required', 'string', 'max:100'],
            'timezone' => ['required', 'string', 'timezone'],
            'locale' => ['required', Rule::in(UiOptionCatalog::localeValues())],
        ]);

        $userId = $request->user()->id;

        $this->settings->put('general', 'display_name', $validated['display_name'], updatedBy: $userId);
        $this->settings->put('general', 'timezone', $validated['timezone'], updatedBy: $userId);
        $this->settings->put('general', 'locale', $validated['locale'], updatedBy: $userId);

        $this->logger->recordEvent('settings.general.updated', ['changed_keys' => array_keys($validated)]);

        return back()->with('success', 'General settings updated.');
    }

    public function generalCompanyInformation(): View
    {
        $this->authorize(SettingsPermissions::VIEW);

        return view('settings::general-company-information', [
            'companyName' => $this->settings->get('general_company', 'name', config('app.name')),
            'companyEmail' => $this->settings->get('general_company', 'email', ''),
            'companyPhone' => $this->settings->get('general_company', 'phone', ''),
            'companyAddress' => $this->settings->get('general_company', 'address', ''),
        ]);
    }

    public function updateGeneralCompanyInformation(Request $request): RedirectResponse
    {
        $this->authorize(SettingsPermissions::UPDATE);

        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:150'],
            'company_email' => ['nullable', 'email', 'max:255'],
            'company_phone' => ['nullable', 'string', 'max:50'],
            'company_address' => ['nullable', 'string', 'max:1000'],
        ]);

        $userId = $request->user()->id;
        $this->settings->put('general_company', 'name', $validated['company_name'], updatedBy: $userId);
        $this->settings->put('general_company', 'email', $validated['company_email'] ?? '', updatedBy: $userId);
        $this->settings->put(
            'general_company',
            'phone',
            InternalPhoneFormatter::normalize($validated['company_phone'] ?? null) ?? '',
            updatedBy: $userId
        );
        $this->settings->put('general_company', 'address', $validated['company_address'] ?? '', updatedBy: $userId);

        $this->logger->recordEvent('settings.general-company.updated', ['changed_keys' => array_keys($validated)]);

        return back()->with('success', 'Company information updated.');
    }

    public function generalLocalization(): View
    {
        $this->authorize(SettingsPermissions::VIEW);

        return view('settings::general-localization', [
            'defaultLanguage' => $this->settings->get('general_localization', 'default_language', config('app.locale')),
            'dateFormat' => $this->settings->get('general_localization', 'date_format', 'M j, Y'),
            'timeFormat' => $this->settings->get('general_localization', 'time_format', 'g:i A'),
            'firstDayOfWeek' => $this->settings->get('general_localization', 'first_day_of_week', 'monday'),
        ]);
    }

    public function updateGeneralLocalization(Request $request): RedirectResponse
    {
        $this->authorize(SettingsPermissions::UPDATE);

        $validated = $request->validate([
            'default_language' => ['required', 'string', 'max:10'],
            'date_format' => ['required', 'string', 'max:40'],
            'time_format' => ['required', 'string', 'max:40'],
            'first_day_of_week' => ['required', Rule::in(['monday', 'sunday'])],
        ]);

        $userId = $request->user()->id;
        $this->settings->put('general_localization', 'default_language', $validated['default_language'], updatedBy: $userId);
        $this->settings->put('general_localization', 'date_format', $validated['date_format'], updatedBy: $userId);
        $this->settings->put('general_localization', 'time_format', $validated['time_format'], updatedBy: $userId);
        $this->settings->put('general_localization', 'first_day_of_week', $validated['first_day_of_week'], updatedBy: $userId);

        $this->logger->recordEvent('settings.general-localization.updated', ['changed_keys' => array_keys($validated)]);

        return back()->with('success', 'Localization settings updated.');
    }

    public function generalEmail(): View
    {
        $this->authorize(SettingsPermissions::VIEW);

        return view('settings::general-email', [
            'fromName' => $this->settings->get('general_email', 'from_name', config('app.name')),
            'fromAddress' => $this->settings->get('general_email', 'from_address', config('mail.from.address')),
            'replyToAddress' => $this->settings->get('general_email', 'reply_to_address', ''),
            'mailDriver' => $this->settings->get('general_email', 'mail_driver', config('mail.default')),
        ]);
    }

    public function updateGeneralEmail(Request $request): RedirectResponse
    {
        $this->authorize(SettingsPermissions::UPDATE);

        $validated = $request->validate([
            'from_name' => ['required', 'string', 'max:150'],
            'from_address' => ['required', 'email', 'max:255'],
            'reply_to_address' => ['nullable', 'email', 'max:255'],
            'mail_driver' => ['required', Rule::in(['smtp', 'sendmail', 'log', 'array'])],
        ]);

        $userId = $request->user()->id;
        $this->settings->put('general_email', 'from_name', $validated['from_name'], updatedBy: $userId);
        $this->settings->put('general_email', 'from_address', $validated['from_address'], updatedBy: $userId);
        $this->settings->put('general_email', 'reply_to_address', $validated['reply_to_address'] ?? '', updatedBy: $userId);
        $this->settings->put('general_email', 'mail_driver', $validated['mail_driver'], updatedBy: $userId);

        $this->logger->recordEvent('settings.general-email.updated', ['changed_keys' => array_keys($validated)]);

        return back()->with('success', 'Email settings updated.');
    }

    public function generalSystemUpdate(): View
    {
        $this->authorize(SettingsPermissions::VIEW);

        return view('settings::general-system-update', [
            'updateChannel' => $this->settings->get('general_system_update', 'channel', 'stable'),
            'autoCheck' => $this->settings->get('general_system_update', 'auto_check', true),
            'maintenanceWindow' => $this->settings->get('general_system_update', 'maintenance_window', 'sunday 02:00-03:00'),
        ]);
    }

    public function updateGeneralSystemUpdate(Request $request): RedirectResponse
    {
        $this->authorize(SettingsPermissions::UPDATE);

        $validated = $request->validate([
            'update_channel' => ['required', Rule::in(['stable', 'preview'])],
            'auto_check' => ['required', 'boolean'],
            'maintenance_window' => ['nullable', 'string', 'max:100'],
        ]);

        $userId = $request->user()->id;
        $this->settings->put('general_system_update', 'channel', $validated['update_channel'], updatedBy: $userId);
        $this->settings->put('general_system_update', 'auto_check', (bool) $validated['auto_check'], updatedBy: $userId);
        $this->settings->put('general_system_update', 'maintenance_window', $validated['maintenance_window'] ?? '', updatedBy: $userId);

        $this->logger->recordEvent('settings.general-system-update.updated', ['changed_keys' => array_keys($validated)]);

        return back()->with('success', 'System update settings updated.');
    }

    public function generalSystemServerInfo(): View
    {
        $this->authorize(SettingsPermissions::VIEW);

        return view('settings::general-system-server-info', [
            'appEnvironment' => app()->environment(),
            'appVersion' => app()->version(),
            'phpVersion' => PHP_VERSION,
            'serverSoftware' => request()->server('SERVER_SOFTWARE', 'unknown'),
            'dbConnection' => config('database.default'),
            'cacheDriver' => config('cache.default'),
            'queueDriver' => config('queue.default'),
        ]);
    }

    public function auditLogs(): View
    {
        $this->authorize(SettingsPermissions::VIEW);

        return view('settings::audit-logs', [
            'retentionDays' => $this->settings->get('audit_logs', 'retention_days', 365),
            'loginEventSeverity' => $this->settings->get('audit_logs', 'login_event_severity', 'info'),
        ]);
    }

    public function updateAuditLogs(Request $request): RedirectResponse
    {
        $this->authorize(SettingsPermissions::UPDATE);

        $validated = $request->validate([
            'retention_days' => ['required', 'integer', 'min:7', 'max:3650'],
            'login_event_severity' => ['required', Rule::in(['info', 'notice', 'security'])],
        ]);

        $userId = $request->user()->id;

        $this->settings->put('audit_logs', 'retention_days', (int) $validated['retention_days'], updatedBy: $userId);
        $this->settings->put('audit_logs', 'login_event_severity', $validated['login_event_severity'], updatedBy: $userId);

        $this->logger->recordEvent('settings.audit-logs.updated', ['changed_keys' => array_keys($validated)]);

        return back()->with('success', 'Audit log settings updated.');
    }

    public function docs(): View
    {
        $this->authorize(SettingsPermissions::VIEW);

        return view('settings::docs', [
            'accessScope' => $this->settings->get('docs', 'access_scope', 'all_platform_users'),
        ]);
    }

    public function updateDocs(Request $request): RedirectResponse
    {
        $this->authorize(SettingsPermissions::UPDATE);

        $validated = $request->validate([
            'access_scope' => ['required', Rule::in(['all_platform_users', 'super_admins_only'])],
        ]);

        $this->settings->put('docs', 'access_scope', $validated['access_scope'], updatedBy: $request->user()->id);

        $this->logger->recordEvent('settings.docs.updated', ['changed_keys' => array_keys($validated)]);

        return back()->with('success', 'Documentation vault settings updated.');
    }

    public function users(): View
    {
        $this->authorize(SettingsPermissions::VIEW);

        $roleCatalog = app(RoleCatalog::class);
        $storedDefaultRole = $this->settings->get('users', 'default_role', RoleCatalog::DEFAULT);
        $defaultRole = is_string($storedDefaultRole)
            ? ($roleCatalog->legacyMap()[$storedDefaultRole] ?? $storedDefaultRole)
            : RoleCatalog::DEFAULT;

        return view('settings::users', [
            'defaultRole' => $defaultRole,
            'defaultActive' => $this->settings->get('users', 'default_active', true),
        ]);
    }

    public function updateUsers(Request $request): RedirectResponse
    {
        $this->authorize(SettingsPermissions::UPDATE);

        $validated = $request->validate([
            'default_role' => ['required', Rule::in(app(RoleCatalog::class)->keys())],
            'default_active' => ['required', 'boolean'],
        ]);

        $userId = $request->user()->id;

        $this->settings->put('users', 'default_role', $validated['default_role'], updatedBy: $userId);
        $this->settings->put('users', 'default_active', (bool) $validated['default_active'], updatedBy: $userId);

        $this->logger->recordEvent('settings.users.updated', ['changed_keys' => array_keys($validated)]);

        return back()->with('success', 'Platform user settings updated.');
    }
}
