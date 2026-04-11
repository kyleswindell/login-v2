<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Http\Requests\Platform\StorePlatformUserRequest;
use App\Http\Requests\Platform\UpdatePlatformUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PlatformUserController extends Controller
{
    public function index(): View
    {
        $this->authorize('manage-platform-users');

        return view('platform.users.index', [
            'users' => User::query()->with('roles')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        $this->authorize('manage-platform-users');

        return view('platform.users.create', [
            'roles' => Role::query()->orderBy('name')->get(),
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

        $user->syncRoles($request->validatedRoles());

        return redirect()
            ->route('platform.users.edit', $user)
            ->with('status', 'User created successfully.');
    }

    public function edit(User $user): View
    {
        $this->authorize('manage-platform-users');

        return view('platform.users.edit', [
            'user' => $user->load('roles'),
            'roles' => Role::query()->orderBy('name')->get(),
            'permissionsByFeature' => $this->permissionsByFeature(),
        ]);
    }

    public function update(UpdatePlatformUserRequest $request, User $user): RedirectResponse
    {
        $this->authorize('manage-platform-users');

        $user->fill($request->validatedExceptRoles());

        if ($request->hasFile('profile_image')) {
            $user->profile_image_path = $request->file('profile_image')->store('profile-images', 'public');
        }

        if ($request->filled('password')) {
            $user->password = $request->string('password')->toString();
        }

        $user->save();
        $user->syncRoles($request->validatedRoles());

        return redirect()
            ->route('platform.users.edit', $user)
            ->with('status', 'User updated successfully.');
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
