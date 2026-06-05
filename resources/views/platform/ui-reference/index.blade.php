<x-layouts.app title="UI Reference Workspace">
    <section class="flex flex-1 flex-col gap-6">
        @include('platform.ui-reference.index.overview')
        @include('platform.ui-reference.index.action-tokens')
        @include('platform.ui-reference.index.forms')
        @include('platform.ui-reference.index.workspace-table')
        @include('platform.ui-reference.index.audit-table')
        @include('platform.ui-reference.index.error-table')
        @include('platform.ui-reference.index.audit-drawer')
        @include('platform.ui-reference.index.error-drawer')
    </section>
</x-layouts.app>
