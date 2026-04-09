<x-layouts.app title="Create Platform User">
    @include('platform.users.partials.form', [
        'heading' => 'Create Platform User',
        'subheading' => 'Create a new internal user and assign their initial platform roles.',
        'action' => route('platform.users.store'),
        'method' => 'POST',
        'user' => null,
    ])
</x-layouts.app>
