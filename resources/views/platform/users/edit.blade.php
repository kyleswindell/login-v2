<x-layouts.app title="Edit Platform User">
    @include('platform.users.partials.form', [
        'heading' => 'Edit Platform User',
        'subheading' => 'Update account details, role assignments, and activation state.',
        'action' => route('platform.users.update', $user),
        'method' => 'PUT',
        'user' => $user,
    ])
</x-layouts.app>
