<x-patterns.widget-shell
    title="Development Tools"
    description="Testing and diagnostic utilities for platform development."
    :meta="['Action widget']"
>
    <div class="space-y-3">
        <div class="ui-pattern-widget-shell-section flex items-center justify-between gap-3">
            <div>
                <p class="text-sm font-medium text-white">Generate Test Notification</p>
                <p class="text-xs text-slate-400">Create a test notification to verify notification delivery and display.</p>
            </div>
            <x-ui.button
                semantic="primary"
                wire:click="generateTestNotification"
                class="flex-shrink-0"
            >
                Generate
            </x-ui.button>
        </div>
    </div>
</x-patterns.widget-shell>
