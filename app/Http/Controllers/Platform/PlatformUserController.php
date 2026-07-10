<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Http\Requests\Platform\StorePlatformUserRequest;
use App\Http\Requests\Platform\UpdatePlatformUserRequest;
use App\Models\User;
use App\Modules\Auth\Notifications\Types as AuthNotificationTypes;
use App\Modules\Notifications\Services\Notifier;
use App\Modules\Roles\Services\AssignmentGuard;
use App\Modules\Roles\Services\UserRoleAssignmentWriter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;

class PlatformUserController extends Controller
{
    public function index(): View
    {
        $this->authorize('view-platform-users');

        return view('platform.users.index', [
            'users' => User::query()->with('roles')->orderBy('name')->get(),
        ]);
    }

    public function create(Request $request): View
    {
        $this->authorize('manage-platform-users');

        return view('platform.users.create', [
            'roles' => app(AssignmentGuard::class)->assignableRolesFor($request->user()),
            'permissionsByFeature' => $this->permissionsByFeature(),
        ]);
    }

    public function store(StorePlatformUserRequest $request): RedirectResponse
    {
        $this->authorize('manage-platform-users');

        $user = User::query()->create($request->validatedExceptRoles());

        if ($request->hasFile('profile_image')) {
            $user->forceFill([
                'profile_image_path' => $request->file('profile_image')->store('profile-images', 'public'),
            ])->save();
        }

        app(UserRoleAssignmentWriter::class)->sync($request->user(), $user, $request->validatedRoles());

        return redirect()
            ->route('platform.users.edit', $user)
            ->with('status', 'User created successfully.');
    }

    public function edit(Request $request, User $user): View
    {
        $this->authorize('manage-platform-users');
        abort_unless(app(AssignmentGuard::class)->canManageTarget($request->user(), $user), 403);

        return view('platform.users.edit', [
            'user' => $user->load('roles'),
            'roles' => app(AssignmentGuard::class)->assignableRolesFor($request->user()),
            'permissionsByFeature' => $this->permissionsByFeature(),
        ]);
    }

    public function update(UpdatePlatformUserRequest $request, User $user): RedirectResponse
    {
        $this->authorize('manage-platform-users');
        abort_unless(app(AssignmentGuard::class)->canManageTarget($request->user(), $user), 403);

        $user->fill($request->validatedExceptRoles());

        if ($request->hasFile('profile_image')) {
            $user->profile_image_path = $request->file('profile_image')->store('profile-images', 'public');
        }

        $passwordChanged = $request->filled('password');

        if ($passwordChanged) {
            $user->password = $request->string('password')->toString();
        }

        $user->save();
        app(UserRoleAssignmentWriter::class)->sync($request->user(), $user, $request->validatedRoles());

        if ($passwordChanged) {
            app(Notifier::class)->send(
                type: AuthNotificationTypes::PASSWORD_CHANGED,
                recipient: $user,
                actor: $request->user(),
                subject: $user,
            );
        }

        return redirect()
            ->route('platform.users.edit', $user)
            ->with('status', 'User updated successfully.');
    }

    public function toggleActive(Request $request, User $user): RedirectResponse
    {
        $this->authorize('manage-platform-users');
        abort_unless(app(AssignmentGuard::class)->canManageTarget($request->user(), $user), 403);

        $targetState = ! $user->is_active;

        if ($request->user()?->is($user) && ! $targetState) {
            return back()->with('status', 'You cannot deactivate your own account.');
        }

        $user->forceFill([
            'is_active' => $targetState,
        ])->save();

        return back()->with('status', $targetState ? 'User activated successfully.' : 'User deactivated successfully.');
    }

    /**
     * @return array<string, list<string>>
     */
    private function permissionsByFeature(): array
    {
        $permissions = Permission::query()->orderBy('name')->pluck('name');

        $grouped = [];

        foreach ($permissions as $permission) {
            $parts = explode('.', $permission);
            $feature = $parts[1] ?? 'general';
            $capability = $parts[2] ?? 'access';

            $featureLabel = str($feature)->replace('-', ' ')->title()->toString();
            $capabilityLabel = str($capability)->replace('-', ' ')->title()->toString();

            $grouped[$featureLabel] ??= [];

            if (! in_array($capabilityLabel, $grouped[$featureLabel], true)) {
                $grouped[$featureLabel][] = $capabilityLabel;
            }
        }

        ksort($grouped);

        return $grouped;
    }
}
