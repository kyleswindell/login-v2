<section class="flex flex-1 flex-col gap-6">
    <div class="ui-platform-surface p-8">
        <p class="ui-platform-kicker text-sm font-medium uppercase tracking-[0.3em]">Platform Management</p>
        <h1 class="ui-platform-text-strong mt-3 text-3xl font-semibold">{{ $heading }}</h1>
        <p class="ui-platform-text-muted mt-2">{{ $subheading }}</p>
    </div>

    @if (session('status'))
        <x-ui.notification.inline kind="success">
            {{ session('status') }}
        </x-ui.notification.inline>
    @endif

    @if ($errors->any())
        <x-ui.notification.inline kind="error">
            <ul class="space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-ui.notification.inline>
    @endif

    <form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="ui-platform-surface p-8">
        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif

        <div class="ui-platform-subtle-surface flex flex-wrap gap-2 p-2" data-staff-form-tabs>
            <button type="button" class="ui-platform-tab is-current rounded-md px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] transition" data-staff-tab-trigger="profile">Profile</button>
            <button type="button" class="ui-platform-tab rounded-md px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] transition" data-staff-tab-trigger="permissions">Permissions</button>
        </div>

        <div class="mt-6 space-y-6" data-staff-tab-panel="profile">
            <div class="grid gap-6 lg:grid-cols-2">
                <label class="block">
                    <span class="ui-platform-text-strong text-sm font-semibold">First Name</span>
                    <input type="text" name="first_name" value="{{ old('first_name', $user?->first_name) }}" class="ui-platform-field mt-2 w-full px-4 py-3" required>
                </label>

                <label class="block">
                    <span class="ui-platform-text-strong text-sm font-semibold">Last Name</span>
                    <input type="text" name="last_name" value="{{ old('last_name', $user?->last_name) }}" class="ui-platform-field mt-2 w-full px-4 py-3" required>
                </label>

                <label class="block">
                    <span class="ui-platform-text-strong text-sm font-semibold">Email</span>
                    <input type="email" name="email" value="{{ old('email', $user?->email) }}" class="ui-platform-field mt-2 w-full px-4 py-3" required>
                </label>

                <label class="block">
                    <span class="ui-platform-text-strong text-sm font-semibold">Hourly Rate ($)</span>
                    <input type="number" min="0" step="0.01" name="hourly_rate" value="{{ old('hourly_rate', $user?->hourly_rate ?? 0) }}" class="ui-platform-field mt-2 w-full px-4 py-3">
                </label>

                <label class="block">
                    <span class="ui-platform-text-strong text-sm font-semibold">Phone</span>
                    <input type="text" name="phone" value="{{ old('phone', $user?->phone) }}" class="ui-platform-field mt-2 w-full px-4 py-3" data-ui-phone-input inputmode="tel" autocomplete="tel" placeholder="(555) 555-5555">
                </label>

                <label class="block">
                    <span class="ui-platform-text-strong text-sm font-semibold">Default Language</span>
                    <input type="text" name="default_language" value="{{ old('default_language', $user?->default_language ?? config('app.locale')) }}" class="ui-platform-field mt-2 w-full px-4 py-3">
                </label>

                <label class="block">
                    <span class="ui-platform-text-strong text-sm font-semibold">Facebook</span>
                    <input type="text" name="facebook" value="{{ old('facebook', $user?->facebook) }}" class="ui-platform-field mt-2 w-full px-4 py-3">
                </label>

                <label class="block">
                    <span class="ui-platform-text-strong text-sm font-semibold">LinkedIn</span>
                    <input type="text" name="linkedin" value="{{ old('linkedin', $user?->linkedin) }}" class="ui-platform-field mt-2 w-full px-4 py-3">
                </label>

                <label class="block">
                    <span class="ui-platform-text-strong text-sm font-semibold">Skype</span>
                    <input type="text" name="skype" value="{{ old('skype', $user?->skype) }}" class="ui-platform-field mt-2 w-full px-4 py-3">
                </label>

                <label class="block">
                    <span class="ui-platform-text-strong text-sm font-semibold">Direction</span>
                    <select name="direction" class="ui-platform-select mt-2 w-full px-4 py-3">
                        <option value="ltr" @selected(old('direction', $user?->direction ?? 'ltr') === 'ltr')>LTR</option>
                        <option value="rtl" @selected(old('direction', $user?->direction ?? 'ltr') === 'rtl')>RTL</option>
                    </select>
                </label>

                <label class="block lg:col-span-2">
                    <span class="ui-platform-text-strong text-sm font-semibold">Email Signature</span>
                    <textarea name="email_signature" rows="3" class="ui-platform-textarea mt-2 w-full px-4 py-3">{{ old('email_signature', $user?->email_signature) }}</textarea>
                </label>

                <label class="block lg:col-span-2">
                    <span class="ui-platform-text-strong text-sm font-semibold">Profile Image</span>
                    <input type="file" name="profile_image" accept="image/*" class="ui-platform-field mt-2 w-full px-4 py-3">
                </label>

                <label class="block lg:col-span-2">
                    <span class="ui-platform-text-strong text-sm font-semibold">Password {{ $user ? '(leave blank to keep current password)' : '' }}</span>
                    <input type="password" name="password" class="ui-platform-field mt-2 w-full px-4 py-3" @if (! $user) required @endif>
                </label>
            </div>

            <div class="grid gap-3 lg:grid-cols-2">
                <label class="ui-platform-subtle-surface flex items-center gap-3 px-4 py-3 text-sm ui-platform-text">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $user?->is_active ?? true)) class="rounded ui-platform-checkbox">
                    <span>Staff account is active</span>
                </label>

                <label class="ui-platform-subtle-surface flex items-center gap-3 px-4 py-3 text-sm ui-platform-text">
                    <input type="hidden" name="is_administrator" value="0">
                    <input type="checkbox" name="is_administrator" value="1" @checked(old('is_administrator', $user?->is_administrator ?? false)) class="rounded ui-platform-checkbox">
                    <span>Administrator</span>
                </label>

                <label class="ui-platform-subtle-surface flex items-center gap-3 px-4 py-3 text-sm ui-platform-text">
                    <input type="hidden" name="not_staff_member" value="0">
                    <input type="checkbox" name="not_staff_member" value="1" @checked(old('not_staff_member', isset($user) ? ! $user->is_staff_member : false)) class="rounded ui-platform-checkbox">
                    <span>Not Staff Member</span>
                </label>

                <label class="ui-platform-subtle-surface flex items-center gap-3 px-4 py-3 text-sm ui-platform-text">
                    <input type="hidden" name="send_welcome_email" value="0">
                    <input type="checkbox" name="send_welcome_email" value="1" @checked(old('send_welcome_email', $user?->send_welcome_email ?? true)) class="rounded ui-platform-checkbox">
                    <span>Send welcome email</span>
                </label>
            </div>
        </div>

        <div class="mt-6 hidden space-y-6" data-staff-tab-panel="permissions">
            <fieldset>
                <legend class="ui-platform-text-strong text-sm font-semibold">Role Assignment</legend>
                <div class="mt-3 grid gap-3 md:grid-cols-2 xl:grid-cols-3">
                    @php
                        $selectedRoles = collect(old('roles', $user?->roles->pluck('name')->all() ?? []));
                    @endphp
                    @foreach ($roles as $role)
                        <label class="ui-platform-subtle-surface flex items-center gap-3 px-4 py-3 text-sm ui-platform-text">
                            <input
                                type="checkbox"
                                name="roles[]"
                                value="{{ $role->name }}"
                                @checked($selectedRoles->contains($role->name))
                                class="rounded ui-platform-checkbox"
                            >
                            <span>{{ $role->name }}</span>
                        </label>
                    @endforeach
                </div>
            </fieldset>

            <div class="ui-platform-subtle-surface p-5">
                <h3 class="ui-platform-kicker text-sm font-semibold uppercase tracking-[0.2em]">Permissions</h3>
                <p class="ui-platform-text-muted mt-2 text-sm">Permission capabilities are grouped by feature from installed permissions. Access is currently controlled through role assignment.</p>

                <div class="mt-4 space-y-4">
                    @foreach (($permissionsByFeature ?? []) as $feature => $capabilities)
                        <div class="ui-platform-subtle-surface p-4">
                            <h4 class="ui-platform-text-strong text-sm font-semibold">{{ $feature }}</h4>
                            <div class="mt-3 flex flex-wrap gap-2">
                                @foreach ($capabilities as $capability)
                                    <span class="ui-platform-pill inline-flex px-3 py-1 text-xs font-medium">{{ $capability }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="ui-platform-border mt-8 flex flex-wrap gap-3 border-t pt-6">
            <button type="submit" class="ui-action ui-action-primary">
                Save User
            </button>

            <a wire:navigate href="{{ route('platform.users.index') }}" class="ui-action">
                Back to Users
            </a>
        </div>
    </form>

    @if ($user)
        @php
            $totpMethod = $user->totpMfaMethod()->first();
            $hasConfirmedMfa = $user->hasConfirmedTotpMfa();
            $hasPendingMfa = filled($totpMethod?->pending_secret);
            $mfaRequired = $user->hasMfaPolicyRequirement();
        @endphp

        <div class="ui-platform-surface p-8">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <p class="ui-platform-kicker text-sm font-medium uppercase tracking-[0.3em]">Account Security</p>
                    <h2 class="ui-platform-text-strong mt-3 text-2xl font-semibold">Multi-Factor Authentication</h2>
                    <p class="ui-platform-text-muted mt-2 text-sm">Admin controls for this user account.</p>
                </div>

                <div class="grid gap-3 text-sm sm:grid-cols-2 lg:min-w-96">
                    <div class="ui-platform-subtle-surface p-4">
                        <p class="ui-platform-kicker text-xs font-semibold uppercase tracking-[0.2em]">Requirement</p>
                        <p class="ui-platform-text-strong mt-2 font-medium">{{ $mfaRequired ? 'Required' : 'Not required' }}</p>
                    </div>
                    <div class="ui-platform-subtle-surface p-4">
                        <p class="ui-platform-kicker text-xs font-semibold uppercase tracking-[0.2em]">Enrollment</p>
                        <p class="ui-platform-text-strong mt-2 font-medium">
                            @if ($hasConfirmedMfa)
                                Enrolled
                            @elseif ($hasPendingMfa)
                                Setup pending
                            @else
                                Not enrolled
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="ui-platform-border mt-6 flex flex-wrap gap-3 border-t pt-6">
                <form method="POST" action="{{ route('platform.users.mfa-requirement', $user) }}">
                    @csrf
                    <input type="hidden" name="mfa_required" value="{{ $mfaRequired ? '0' : '1' }}">
                    <button type="submit" class="ui-action {{ $mfaRequired ? '' : 'ui-action-primary' }}">
                        {{ $mfaRequired ? 'Disable MFA Requirement' : 'Require MFA' }}
                    </button>
                </form>

                <form method="POST" action="{{ route('platform.users.mfa-reset', $user) }}">
                    @csrf
                    <button type="submit" class="ui-action" {{ ! $hasConfirmedMfa && ! $hasPendingMfa ? 'disabled' : '' }}>
                        Reset MFA Enrollment
                    </button>
                </form>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const wrapper = document.querySelector('[data-staff-form-tabs]');
            if (!wrapper) return;

            const triggers = wrapper.querySelectorAll('[data-staff-tab-trigger]');
            const panels = document.querySelectorAll('[data-staff-tab-panel]');

            const activate = (target) => {
                panels.forEach((panel) => {
                    panel.classList.toggle('hidden', panel.dataset.staffTabPanel !== target);
                });

                triggers.forEach((trigger) => {
                    const active = trigger.dataset.staffTabTrigger === target;
                    trigger.classList.toggle('is-current', active);
                });
            };

            triggers.forEach((trigger) => {
                trigger.addEventListener('click', () => activate(trigger.dataset.staffTabTrigger));
            });

            activate('profile');
        });
    </script>
</section>
