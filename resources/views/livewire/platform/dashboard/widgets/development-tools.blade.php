<section class="rounded-lg border border-slate-800 bg-slate-900/70 p-5">
    <div class="mb-4 flex items-center justify-between gap-3">
        <div>
            <h2 class="text-base font-semibold text-white">Development Tools</h2>
            <p class="text-sm text-slate-400">Testing and diagnostic utilities for platform development.</p>
        </div>
    </div>

    <div class="space-y-3">
        <div class="flex items-center justify-between gap-3 rounded-lg border border-slate-800 bg-slate-950/70 px-4 py-3">
            <div>
                <p class="text-sm font-medium text-white">Generate Test Notification</p>
                <p class="text-xs text-slate-400">Create a test notification to verify notification delivery and display.</p>
            </div>
            <button
                type="button"
                wire:click="generateTestNotification"
                class="ui-action ui-action-primary flex-shrink-0"
            >
                Generate
            </button>
        </div>
    </div>
</section>