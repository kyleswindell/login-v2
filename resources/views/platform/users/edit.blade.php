<x-layouts.app title="Edit Staff Member">
    @include('platform.users.partials.form', [
        'heading' => 'Edit Staff Member',
        'subheading' => 'Update staff profile details, permission assignments, and account lifecycle state.',
        'action' => route('platform.users.update', $user),
        'method' => 'PUT',
        'user' => $user,
    ])
</x-layouts.app>
