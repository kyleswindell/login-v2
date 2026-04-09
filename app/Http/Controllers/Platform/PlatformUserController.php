<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Http\Requests\Platform\StorePlatformUserRequest;
use App\Http\Requests\Platform\UpdatePlatformUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
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
        ]);
    }

    public function store(StorePlatformUserRequest $request): RedirectResponse
    {
        $this->authorize('manage-platform-users');

        $user = User::query()->create($request->validatedExceptRoles());
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
        ]);
    }

    public function update(UpdatePlatformUserRequest $request, User $user): RedirectResponse
    {
        $this->authorize('manage-platform-users');

        $user->fill($request->validatedExceptRoles());

        if ($request->filled('password')) {
            $user->password = $request->string('password')->toString();
        }

        $user->save();
        $user->syncRoles($request->validatedRoles());

        return redirect()
            ->route('platform.users.edit', $user)
            ->with('status', 'User updated successfully.');
    }
}
