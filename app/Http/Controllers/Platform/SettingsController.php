<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Platform\Logging\PlatformLogger;
use App\Platform\Settings\SettingsService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    public function __construct(
        private readonly SettingsService $settings,
        private readonly PlatformLogger $logger,
    ) {}

    public function general(): View
    {
        $this->authorize('manage-platform-settings');

        return view('platform.settings.general', [
            'displayName' => $this->settings->get('general', 'display_name', config('app.name')),
            'timezone' => $this->settings->get('general', 'timezone', config('app.timezone')),
            'locale' => $this->settings->get('general', 'locale', config('app.locale')),
        ]);
    }

    public function updateGeneral(Request $request): RedirectResponse
    {
        $this->authorize('manage-platform-settings');

        $validated = $request->validate([
            'display_name' => ['required', 'string', 'max:100'],
            'timezone' => ['required', 'string', 'timezone'],
            'locale' => ['required', 'string', 'max:10'],
        ]);

        $userId = $request->user()->id;

        $this->settings->put('general', 'display_name', $validated['display_name'], updatedBy: $userId);
        $this->settings->put('general', 'timezone', $validated['timezone'], updatedBy: $userId);
        $this->settings->put('general', 'locale', $validated['locale'], updatedBy: $userId);

        $this->logger->recordEvent('settings.general.updated', ['changed_keys' => array_keys($validated)]);

        return back()->with('success', 'General settings updated.');
    }

    public function notifications(): View
    {
        $this->authorize('manage-platform-settings');

        return view('platform.settings.notifications', [
            'defaultSeverity' => $this->settings->get('notifications', 'default_severity', 'info'),
            'maxPerUser' => $this->settings->get('notifications', 'max_per_user', 100),
        ]);
    }

    public function updateNotifications(Request $request): RedirectResponse
    {
        $this->authorize('manage-platform-settings');

        $validated = $request->validate([
            'default_severity' => ['required', Rule::in(['info', 'notice', 'success', 'warning', 'error', 'urgent'])],
            'max_per_user' => ['required', 'integer', 'min:10', 'max:10000'],
        ]);

        $userId = $request->user()->id;

        $this->settings->put('notifications', 'default_severity', $validated['default_severity'], updatedBy: $userId);
        $this->settings->put('notifications', 'max_per_user', (int) $validated['max_per_user'], updatedBy: $userId);

        $this->logger->recordEvent('settings.notifications.updated', ['changed_keys' => array_keys($validated)]);

        return back()->with('success', 'Notification settings updated.');
    }

    public function auditLogs(): View
    {
        $this->authorize('manage-platform-settings');

        return view('platform.settings.audit-logs', [
            'retentionDays' => $this->settings->get('audit_logs', 'retention_days', 365),
            'loginEventSeverity' => $this->settings->get('audit_logs', 'login_event_severity', 'info'),
        ]);
    }

    public function updateAuditLogs(Request $request): RedirectResponse
    {
        $this->authorize('manage-platform-settings');

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
        $this->authorize('manage-platform-settings');

        return view('platform.settings.docs', [
            'accessScope' => $this->settings->get('docs', 'access_scope', 'all_platform_users'),
        ]);
    }

    public function updateDocs(Request $request): RedirectResponse
    {
        $this->authorize('manage-platform-settings');

        $validated = $request->validate([
            'access_scope' => ['required', Rule::in(['all_platform_users', 'super_admins_only'])],
        ]);

        $this->settings->put('docs', 'access_scope', $validated['access_scope'], updatedBy: $request->user()->id);

        $this->logger->recordEvent('settings.docs.updated', ['changed_keys' => array_keys($validated)]);

        return back()->with('success', 'Documentation vault settings updated.');
    }

    public function users(): View
    {
        $this->authorize('manage-platform-settings');

        return view('platform.settings.users', [
            'defaultRole' => $this->settings->get('users', 'default_role', 'platform_operator'),
            'defaultActive' => $this->settings->get('users', 'default_active', true),
        ]);
    }

    public function updateUsers(Request $request): RedirectResponse
    {
        $this->authorize('manage-platform-settings');

        $validated = $request->validate([
            'default_role' => ['required', Rule::in(['platform_super_admin', 'platform_admin', 'platform_operator'])],
            'default_active' => ['required', 'boolean'],
        ]);

        $userId = $request->user()->id;

        $this->settings->put('users', 'default_role', $validated['default_role'], updatedBy: $userId);
        $this->settings->put('users', 'default_active', (bool) $validated['default_active'], updatedBy: $userId);

        $this->logger->recordEvent('settings.users.updated', ['changed_keys' => array_keys($validated)]);

        return back()->with('success', 'Platform user settings updated.');
    }
}
