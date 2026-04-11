<x-layouts.app title="Add New Staff Member">
    @include('platform.users.partials.form', [
        'heading' => 'Add New Staff Member',
        'subheading' => 'Create staff profile details and assign permissions using role-based access.',
        'action' => route('platform.users.store'),
        'method' => 'POST',
        'user' => null,
    ])
</x-layouts.app>
