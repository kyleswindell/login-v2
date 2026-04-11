<section class="flex flex-1 flex-col gap-6">
    <div class="rounded-3xl border border-slate-800 bg-slate-900/70 p-8 shadow-2xl shadow-black/30">
        <p class="text-sm font-medium uppercase tracking-[0.3em] text-sky-300">Platform Management</p>
        <h1 class="mt-3 text-3xl font-semibold text-white">{{ $heading }}</h1>
        <p class="mt-2 text-slate-400">{{ $subheading }}</p>
    </div>

    @if (session('status'))
        <div class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-2xl border border-rose-500/30 bg-rose-500/10 px-4 py-3 text-sm text-rose-200">
            <ul class="space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="rounded-3xl border border-slate-800 bg-slate-900/70 p-8">
        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif

        <div class="flex flex-wrap gap-2 rounded-2xl border border-slate-800 bg-slate-950/70 p-2" data-staff-form-tabs>
            <button type="button" class="rounded-xl bg-sky-500/20 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-sky-200 ring-1 ring-sky-500/30" data-staff-tab-trigger="profile">Profile</button>
            <button type="button" class="rounded-xl px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-slate-300 transition hover:bg-slate-800 hover:text-white" data-staff-tab-trigger="permissions">Permissions</button>
        </div>

        <div class="mt-6 space-y-6" data-staff-tab-panel="profile">
            <div class="grid gap-6 lg:grid-cols-2">
                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">First Name</span>
                    <input type="text" name="first_name" value="{{ old('first_name', $user?->first_name) }}" class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100" required>
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Last Name</span>
                    <input type="text" name="last_name" value="{{ old('last_name', $user?->last_name) }}" class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100" required>
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Email</span>
                    <input type="email" name="email" value="{{ old('email', $user?->email) }}" class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100" required>
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Hourly Rate ($)</span>
                    <input type="number" min="0" step="0.01" name="hourly_rate" value="{{ old('hourly_rate', $user?->hourly_rate ?? 0) }}" class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100">
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Phone</span>
                    <input type="text" name="phone" value="{{ old('phone', $user?->phone) }}" class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100">
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Default Language</span>
                    <input type="text" name="default_language" value="{{ old('default_language', $user?->default_language ?? config('app.locale')) }}" class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100">
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Facebook</span>
                    <input type="text" name="facebook" value="{{ old('facebook', $user?->facebook) }}" class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100">
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">LinkedIn</span>
                    <input type="text" name="linkedin" value="{{ old('linkedin', $user?->linkedin) }}" class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100">
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Skype</span>
                    <input type="text" name="skype" value="{{ old('skype', $user?->skype) }}" class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100">
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Direction</span>
                    <select name="direction" class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100">
                        <option value="ltr" @selected(old('direction', $user?->direction ?? 'ltr') === 'ltr')>LTR</option>
                        <option value="rtl" @selected(old('direction', $user?->direction ?? 'ltr') === 'rtl')>RTL</option>
                    </select>
                </label>

                <label class="block lg:col-span-2">
                    <span class="text-sm font-semibold text-slate-200">Email Signature</span>
                    <textarea name="email_signature" rows="3" class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100">{{ old('email_signature', $user?->email_signature) }}</textarea>
                </label>

                <label class="block lg:col-span-2">
                    <span class="text-sm font-semibold text-slate-200">Profile Image</span>
                    <input type="file" name="profile_image" accept="image/*" class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100">
                </label>

                <label class="block lg:col-span-2">
                    <span class="text-sm font-semibold text-slate-200">Password {{ $user ? '(leave blank to keep current password)' : '' }}</span>
                    <input type="password" name="password" class="mt-2 w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100" @if (! $user) required @endif>
                </label>
            </div>

            <div class="grid gap-3 lg:grid-cols-2">
                <label class="flex items-center gap-3 rounded-xl border border-slate-800 bg-slate-950 px-4 py-3 text-sm text-slate-200">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $user?->is_active ?? true)) class="rounded border-slate-600 bg-slate-900 text-sky-400 focus:ring-sky-400">
                    <span>Staff account is active</span>
                </label>

                <label class="flex items-center gap-3 rounded-xl border border-slate-800 bg-slate-950 px-4 py-3 text-sm text-slate-200">
                    <input type="hidden" name="is_administrator" value="0">
                    <input type="checkbox" name="is_administrator" value="1" @checked(old('is_administrator', $user?->is_administrator ?? false)) class="rounded border-slate-600 bg-slate-900 text-sky-400 focus:ring-sky-400">
                    <span>Administrator</span>
                </label>

                <label class="flex items-center gap-3 rounded-xl border border-slate-800 bg-slate-950 px-4 py-3 text-sm text-slate-200">
                    <input type="hidden" name="not_staff_member" value="0">
                    <input type="checkbox" name="not_staff_member" value="1" @checked(old('not_staff_member', isset($user) ? ! $user->is_staff_member : false)) class="rounded border-slate-600 bg-slate-900 text-sky-400 focus:ring-sky-400">
                    <span>Not Staff Member</span>
                </label>

                <label class="flex items-center gap-3 rounded-xl border border-slate-800 bg-slate-950 px-4 py-3 text-sm text-slate-200">
                    <input type="hidden" name="send_welcome_email" value="0">
                    <input type="checkbox" name="send_welcome_email" value="1" @checked(old('send_welcome_email', $user?->send_welcome_email ?? true)) class="rounded border-slate-600 bg-slate-900 text-sky-400 focus:ring-sky-400">
                    <span>Send welcome email</span>
                </label>
            </div>
        </div>

        <div class="mt-6 hidden space-y-6" data-staff-tab-panel="permissions">
            <fieldset>
                <legend class="text-sm font-semibold text-slate-200">Role Assignment</legend>
                <div class="mt-3 grid gap-3 md:grid-cols-2 xl:grid-cols-3">
                    @php($selectedRoles = collect(old('roles', $user?->roles->pluck('name')->all() ?? [])))
                    @foreach ($roles as $role)
                        <label class="flex items-center gap-3 rounded-xl border border-slate-800 bg-slate-950 px-4 py-3 text-sm text-slate-200">
                            <input
                                type="checkbox"
                                name="roles[]"
                                value="{{ $role->name }}"
                                @checked($selectedRoles->contains($role->name))
                                class="rounded border-slate-600 bg-slate-900 text-sky-400 focus:ring-sky-400"
                            >
                            <span>{{ $role->name }}</span>
                        </label>
                    @endforeach
                </div>
            </fieldset>

            <div class="rounded-2xl border border-slate-800 bg-slate-950/70 p-5">
                <h3 class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-300">Permissions</h3>
                <p class="mt-2 text-sm text-slate-500">Permission capabilities are grouped by feature from installed permissions. Access is currently controlled through role assignment.</p>

                <div class="mt-4 space-y-4">
                    @foreach (($permissionsByFeature ?? []) as $feature => $capabilities)
                        <div class="rounded-xl border border-slate-800 bg-slate-900/60 p-4">
                            <h4 class="text-sm font-semibold text-white">{{ $feature }}</h4>
                            <div class="mt-3 flex flex-wrap gap-2">
                                @foreach ($capabilities as $capability)
                                    <span class="inline-flex rounded-full bg-slate-800 px-3 py-1 text-xs font-medium text-slate-200">{{ $capability }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        </div>

        <div class="mt-8 flex flex-wrap gap-3">
            <button type="submit" class="inline-flex rounded-xl border border-slate-700 px-4 py-3 text-sm font-semibold text-slate-100 transition hover:border-sky-400 hover:text-sky-300">
                Save User
            </button>

            <a href="{{ route('platform.users.index') }}" class="inline-flex rounded-xl border border-slate-800 px-4 py-3 text-sm font-semibold text-slate-300 transition hover:border-slate-600 hover:text-white">
                Back to Users
            </a>
        </div>
    </form>

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
                    trigger.classList.toggle('bg-sky-500/20', active);
                    trigger.classList.toggle('text-sky-200', active);
                    trigger.classList.toggle('ring-1', active);
                    trigger.classList.toggle('ring-sky-500/30', active);
                    trigger.classList.toggle('text-slate-300', !active);
                });
            };

            triggers.forEach((trigger) => {
                trigger.addEventListener('click', () => activate(trigger.dataset.staffTabTrigger));
            });

            activate('profile');
        });
    </script>
</section>
