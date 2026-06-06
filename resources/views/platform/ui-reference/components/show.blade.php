<x-layouts.app :title="'UI Reference - '.$catalogComponent['label']">
    <x-slot:sidebar>
        @include('platform.ui-reference.partials.sidebar', ['currentSection' => $currentSection ?? 'components.'.$catalogComponent['slug']])
    </x-slot:sidebar>

    @php
        $slug = $catalogComponent['slug'];
        $ownerRoute = $catalogComponent['owner_route'];
        $implementationPages = ['button', 'tag', 'text-input', 'select', 'date-picker', 'dropdown', 'file-uploader', 'search', 'link', 'tile', 'toggle', 'modal', 'notification', 'inline-loading', 'loading', 'tooltip', 'toggletip', 'menu-buttons', 'data-table', 'accordion', 'breadcrumb'];
    @endphp

    <section class="flex flex-1 flex-col gap-6" data-ui-reference-t1-component="{{ $slug }}" data-ui-reference-component-disposition="{{ $catalogComponent['disposition'] }}">
        <div>
            <p class="ui-kicker">{{ $catalogComponent['group'] }} - {{ $catalogComponent['disposition'] }}</p>
            <h1 class="ui-page-header-title">{{ $catalogComponent['label'] }}</h1>
            <p class="ui-page-header-copy">{{ $catalogComponent['summary'] }}</p>
        </div>

        <section class="ui-card">
            <div class="grid gap-5 xl:grid-cols-[minmax(0,1.5fr)_minmax(18rem,0.5fr)]">
                <div>
                    <h2 class="ui-card-title">Component Contract</h2>
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach ($catalogComponent['states'] as $state)
                            <span class="rounded-full border border-slate-700 bg-slate-950 px-3 py-1 text-xs font-semibold text-slate-300">{{ $state }}</span>
                        @endforeach
                    </div>
                    <dl class="mt-5 space-y-3 text-sm text-slate-300">
                        @foreach ($catalogComponent['guidance'] as $guidance)
                            <div>
                                <dt class="font-semibold text-slate-100">Usage rule</dt>
                                <dd class="mt-1">{{ $guidance }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
                <aside class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                    <p class="ui-kicker">Implementation Guide</p>
                    <dl class="mt-3 space-y-3 text-sm">
                        <div>
                            <dt class="text-slate-500">Owner route</dt>
                            <dd class="mt-1 break-all font-medium text-slate-200">{{ $ownerRoute }}</dd>
                        </div>
                        <div>
                            <dt class="text-slate-500">Route name</dt>
                            <dd class="mt-1 font-medium text-slate-200">{{ $catalogComponent['route_name'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-slate-500">Status</dt>
                            <dd class="mt-1 font-medium text-slate-200">{{ $catalogComponent['disposition'] }}</dd>
                        </div>
                    </dl>
                </aside>
            </div>
        </section>

        @if ($slug === 'number-input')
            <section class="ui-card" data-ui-reference-example="number-input-state-matrix">
                <h2 class="ui-card-title">Number Input State Matrix</h2>
                <p class="ui-card-copy mt-2">Numeric controls use native number semantics plus visible Stepper controls when small increments are expected. Use <code>min="0"</code>, <code>max="4"</code>, and <code>step="1"</code> style constraints whenever range rules are known.</p>
                <div class="mt-5 grid gap-4 xl:grid-cols-2">
                    @foreach ([
                        ['Default number input', 'Editor(s)', '4', ''],
                        ['Fluid number input', 'Retry delay minutes', '15', 'w-full'],
                        ['Disabled', 'Locked seats', '2', 'disabled'],
                        ['Read-only', 'Current tenants', '12', 'readonly'],
                        ['Focus', 'Workspace limit', '8', 'autofocus'],
                    ] as [$title, $label, $value, $state])
                        <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                            <p class="text-sm font-semibold text-white">{{ $title }}</p>
                            <label class="mt-4 block text-sm font-medium text-slate-200">{{ $label }}</label>
                            <div class="mt-2 flex max-w-md items-stretch rounded-md border border-slate-700 bg-slate-950 {{ $state === 'autofocus' ? 'ring-2 ring-sky-400' : '' }}">
                                <input type="number" min="0" max="4" step="1" value="{{ $value }}" class="ui-input rounded-r-none border-0" @disabled($state === 'disabled') @readonly($state === 'readonly')>
                                <button type="button" class="border-l border-slate-800 px-3 text-slate-400" aria-label="Decrease">-</button>
                                <button type="button" class="border-l border-slate-800 px-3 text-slate-200" aria-label="Increase">+</button>
                            </div>
                        </div>
                    @endforeach
                    <div class="rounded-lg border border-rose-500 bg-rose-950/20 p-4">
                        <p class="text-sm font-semibold text-white">Error with inline status icon</p>
                        <label class="mt-4 block text-sm font-medium text-slate-200">Editor(s)</label>
                        <div class="mt-2 flex max-w-md items-stretch rounded-md border border-rose-500 bg-slate-950">
                            <input type="number" min="0" max="4" step="1" value="5" aria-invalid="true" class="ui-input rounded-r-none border-0">
                            <span class="grid place-items-center border-l border-rose-500 px-3 text-rose-300" aria-hidden="true">!</span>
                            <button type="button" class="border-l border-slate-800 px-3 text-slate-400" aria-label="Decrease">-</button>
                            <button type="button" class="border-l border-slate-800 px-3 text-slate-200" aria-label="Increase">+</button>
                        </div>
                        <p class="mt-2 text-sm text-rose-200">Enter a valid number (maximum of 4).</p>
                    </div>
                    <div class="rounded-lg border border-amber-500 bg-amber-950/20 p-4">
                        <p class="text-sm font-semibold text-white">Warning with inline status icon</p>
                        <label class="mt-4 block text-sm font-medium text-slate-200">Retry attempts</label>
                        <div class="mt-2 flex max-w-md items-stretch rounded-md border border-amber-500 bg-slate-950">
                            <input type="number" min="0" max="4" step="1" value="4" class="ui-input rounded-r-none border-0">
                            <span class="grid place-items-center border-l border-amber-500 px-3 text-amber-200" aria-hidden="true">!</span>
                            <button type="button" class="border-l border-slate-800 px-3 text-slate-400" aria-label="Decrease">-</button>
                            <button type="button" class="border-l border-slate-800 px-3 text-slate-200" aria-label="Increase">+</button>
                        </div>
                        <p class="mt-2 text-sm text-amber-100">Maximum reached. Confirm this is intentional.</p>
                    </div>
                </div>
                <div class="mt-5 rounded-lg border border-slate-800 bg-slate-950/70 p-4 text-sm text-slate-300">
                    <p class="font-semibold text-slate-100">Keyboard behavior</p>
                    <p class="mt-1">Tab moves into the input, ArrowUp and ArrowDown increment by step, Home and End may jump to min/max when the browser provides native support, and typed values validate on blur and submit.</p>
                </div>
            </section>
        @elseif ($slug === 'radio-button')
            <section class="ui-card" data-ui-reference-example="radio-button-depth-matrix">
                <h2 class="ui-card-title">Radio Button Depth Matrix</h2>
                <p class="ui-card-copy mt-2">Radio groups are single-select only. Use checkbox groups for multi-select choices.</p>
                <div class="mt-5 grid gap-4 xl:grid-cols-2">
                    <fieldset class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                        <legend class="text-sm font-semibold text-white">Vertical group</legend>
                        @foreach (['Owner', 'Editor', 'Viewer'] as $role)
                            <label class="mt-3 flex items-center gap-3 text-sm text-slate-200"><input type="radio" name="role_vertical" @checked($role === 'Editor')> {{ $role }}</label>
                        @endforeach
                    </fieldset>
                    <fieldset class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                        <legend class="text-sm font-semibold text-white">Horizontal group</legend>
                        <div class="mt-3 flex flex-wrap gap-5">
                            @foreach (['Daily', 'Weekly', 'Monthly'] as $frequency)
                                <label class="flex items-center gap-3 text-sm text-slate-200"><input type="radio" name="frequency" @checked($frequency === 'Weekly')> {{ $frequency }}</label>
                            @endforeach
                        </div>
                    </fieldset>
                    <fieldset class="rounded-lg border border-rose-500 bg-rose-950/20 p-4">
                        <legend class="text-sm font-semibold text-white">Error group state</legend>
                        <p class="mt-1 text-sm text-rose-200">Choose one permission level before continuing.</p>
                        <label class="mt-3 flex items-center gap-3 text-sm text-slate-200"><input type="radio" name="radio_error" aria-invalid="true"> Admin</label>
                    </fieldset>
                    <fieldset class="rounded-lg border border-amber-500 bg-amber-950/20 p-4">
                        <legend class="text-sm font-semibold text-white">Warning and helper text</legend>
                        <p class="mt-1 text-sm text-amber-100">This changes notification volume for every workspace operator.</p>
                        <label class="mt-3 flex items-center gap-3 text-sm text-slate-200"><input type="radio" name="radio_warning" checked> Immediate</label>
                    </fieldset>
                    <fieldset class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                        <legend class="text-sm font-semibold text-white">Disabled and read-only</legend>
                        <label class="mt-3 flex items-center gap-3 text-sm text-slate-500"><input type="radio" disabled> Disabled option</label>
                        <label class="mt-3 flex items-center gap-3 text-sm text-slate-300"><input type="radio" checked readonly> Read-only selected option</label>
                    </fieldset>
                    <fieldset class="rounded-lg border border-sky-400 bg-slate-950/70 p-4 ring-2 ring-sky-400">
                        <legend class="text-sm font-semibold text-white">Focus state</legend>
                        <label class="mt-3 flex items-center gap-3 text-sm text-slate-200"><input type="radio" checked> Focused selected option</label>
                    </fieldset>
                </div>
            </section>
        @elseif ($slug === 'checkbox')
            <section class="ui-card" data-ui-reference-example="checkbox-depth-matrix">
                <h2 class="ui-card-title">Checkbox Depth Matrix</h2>
                <p class="ui-card-copy mt-2">Checkboxes represent independent choices or multi-select groups. Use radio buttons when exactly one visible option must be selected.</p>
                <div class="mt-5 grid gap-4 xl:grid-cols-2">
                    <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                        <p class="text-sm font-semibold text-white">Independent choice</p>
                        <label class="mt-3 flex items-center gap-3 text-sm text-slate-200"><input type="checkbox" checked> Remember this browser</label>
                    </div>
                    <fieldset class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                        <legend class="text-sm font-semibold text-white">Multi-select group</legend>
                        @foreach (['Email', 'In-app', 'Slack handoff'] as $channel)
                            <label class="mt-3 flex items-center gap-3 text-sm text-slate-200"><input type="checkbox" @checked($channel !== 'Slack handoff')> {{ $channel }}</label>
                        @endforeach
                    </fieldset>
                    <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                        <p class="text-sm font-semibold text-white">Checked, unchecked, indeterminate</p>
                        <label class="mt-3 flex items-center gap-3 text-sm text-slate-200"><input type="checkbox" checked> Checked</label>
                        <label class="mt-3 flex items-center gap-3 text-sm text-slate-200"><input type="checkbox"> Unchecked</label>
                        <p class="mt-3 text-sm text-slate-400">Indeterminate state is queued until a supported tree/list selection consumer exists.</p>
                    </div>
                    <fieldset class="rounded-lg border border-rose-500 bg-rose-950/20 p-4">
                        <legend class="text-sm font-semibold text-white">Error and warning</legend>
                        <label class="mt-3 flex items-center gap-3 text-sm text-slate-200"><input type="checkbox" aria-invalid="true"> I acknowledge the change</label>
                        <p class="mt-2 text-sm text-rose-200">Required acknowledgment is missing.</p>
                        <p class="mt-2 text-sm text-amber-100">Warning states must describe impact, not just color the row.</p>
                    </fieldset>
                    <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                        <p class="text-sm font-semibold text-white">Disabled and read-only</p>
                        <label class="mt-3 flex items-center gap-3 text-sm text-slate-500"><input type="checkbox" disabled> Disabled choice</label>
                        <label class="mt-3 flex items-center gap-3 text-sm text-slate-300"><input type="checkbox" checked readonly> Read-only checked choice</label>
                    </div>
                </div>
            </section>
        @elseif ($slug === 'pagination')
            <section class="ui-card" data-ui-reference-example="pagination-depth-matrix">
                <h2 class="ui-card-title">Pagination Variants</h2>
                <div class="mt-5 space-y-4">
                    <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                        <p class="text-sm font-semibold text-white">Full pagination with page-size selector</p>
                        <div class="mt-3 flex flex-wrap items-center justify-between gap-3 text-sm text-slate-300">
                            <span>1-25 of 186</span>
                            <label>Rows per page <select class="ui-input ml-2 w-24"><option>25</option><option>50</option></select></label>
                            <nav class="flex items-center gap-1" aria-label="Pagination"><button class="ui-button-secondary" disabled>Previous</button><button class="ui-button-secondary">1</button><button class="ui-button-secondary">2</button><span class="px-2">...</span><button class="ui-button-secondary">8</button><button class="ui-button-secondary">Next</button></nav>
                        </div>
                    </div>
                    <div class="grid gap-4 xl:grid-cols-3">
                        <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><p class="font-semibold text-white">Compact nav</p><p class="mt-2 text-sm text-slate-300">Previous / next only for dense panes.</p></div>
                        <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><p class="font-semibold text-white">Overflow</p><p class="mt-2 text-sm text-slate-300">Use an ellipsis when page count exceeds visible width.</p></div>
                        <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><p class="font-semibold text-white">Size pairings</p><p class="mt-2 text-sm text-slate-300">Small, medium, and large controls should match related table density and sit below related content.</p></div>
                    </div>
                </div>
            </section>
        @elseif ($slug === 'structured-list')
            <section class="ui-card" data-ui-reference-example="structured-list-depth-matrix">
                <h2 class="ui-card-title">Structured List Variants</h2>
                <div class="mt-5 grid gap-4 xl:grid-cols-2">
                    @foreach (['Default structured list', 'Selectable structured list', 'Condensed density', 'Hang alignment', 'Flush alignment', 'Skeleton state'] as $title)
                        <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                            <p class="text-sm font-semibold text-white">{{ $title }}</p>
                            <div class="mt-3 divide-y divide-slate-800 rounded-md border border-slate-800">
                                <div class="grid grid-cols-[1fr_auto] gap-4 p-3 text-sm"><span class="text-slate-200">Workspace policy</span><span class="text-slate-400">Enabled</span></div>
                                <div class="grid grid-cols-[1fr_auto] gap-4 p-3 text-sm"><span class="text-slate-200">Review gate</span><span class="text-slate-400">Required</span></div>
                            </div>
                            <p class="mt-2 text-xs text-slate-500">Selected, focus, disabled, and skeleton states must be visible before feature adoption.</p>
                        </div>
                    @endforeach
                </div>
            </section>
        @elseif ($slug === 'tabs')
            <section class="ui-card" data-ui-reference-example="tabs-depth-matrix">
                <h2 class="ui-card-title">Tabs Variants</h2>
                <div class="mt-5 grid gap-4 xl:grid-cols-2">
                    @foreach (['Line tabs', 'Contained tabs', 'Vertical tabs', 'Line tabs with icon', 'Icon-only line tabs', 'Overflow / scroll tabs'] as $title)
                        <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                            <p class="text-sm font-semibold text-white">{{ $title }}</p>
                            <div class="mt-3 flex flex-wrap gap-2 text-sm">
                                <span class="border-b-2 border-sky-400 px-3 py-2 text-white">Overview</span>
                                <span class="px-3 py-2 text-slate-400">Usage</span>
                                <span class="px-3 py-2 text-slate-500">Disabled</span>
                            </div>
                            <p class="mt-3 text-sm text-slate-400">Includes selected, focus, disabled, tab panel, and tab-vs-progress/comparison guidance.</p>
                        </div>
                    @endforeach
                </div>
            </section>
        @elseif ($slug === 'menu')
            <section class="ui-card" data-ui-reference-example="menu-depth-matrix">
                <h2 class="ui-card-title">Menu Variants</h2>
                <div class="mt-5 grid gap-4 xl:grid-cols-2">
                    <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                        <p class="text-sm font-semibold text-white">Action items, sizing, and alignment</p>
                        <div class="mt-3 w-64 rounded-md border border-slate-700 bg-slate-950 p-1 text-sm">
                            <button class="block w-full rounded px-3 py-2 text-left text-slate-200">Open details</button>
                            <button class="block w-full rounded bg-slate-800 px-3 py-2 text-left text-white">Current item</button>
                            <button class="block w-full rounded px-3 py-2 text-left text-slate-500" disabled>Disabled item</button>
                            <hr class="my-1 border-slate-800">
                            <button class="block w-full rounded px-3 py-2 text-left text-rose-200">Delete workspace</button>
                        </div>
                    </div>
                    <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                        <p class="text-sm font-semibold text-white">Keyboard and submenu boundary</p>
                        <p class="mt-2 text-sm text-slate-300">Arrow keys move between items, Enter activates, Escape closes and returns focus to the trigger. Submenus are a queued boundary until a real nested-action consumer exists.</p>
                    </div>
                </div>
            </section>
        @elseif (in_array($slug, ['ui-shell-header', 'ui-shell-left-panel', 'ui-shell-right-panel'], true))
            <section class="ui-card" data-ui-reference-example="ui-shell-disposition">
                <h2 class="ui-card-title">UI Shell Disposition</h2>
                <p class="ui-card-copy mt-2">UI shell pieces remain visible in the T1 catalog so they are not silently ignored, but composition ownership belongs to T2 navigation and layout surfaces unless a standalone primitive emerges.</p>
                <div class="mt-5 grid gap-4 xl:grid-cols-3">
                    <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><p class="font-semibold text-white">Header content</p><p class="mt-2 text-sm text-slate-300">Global app heading, account menu, notification handoff, and top-level actions.</p></div>
                    <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><p class="font-semibold text-white">Left panel</p><p class="mt-2 text-sm text-slate-300">Primary app navigation, active route, and section grouping.</p></div>
                    <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4"><p class="font-semibold text-white">Right panel</p><p class="mt-2 text-sm text-slate-300">Queued gap until persistent right-side context is needed beyond drawers.</p></div>
                </div>
            </section>
        @elseif (in_array($slug, $implementationPages, true))
            <section class="ui-card" data-ui-reference-example="component-reference-contract">
                <h2 class="ui-card-title">{{ $catalogComponent['label'] }} Reference Examples</h2>
                <div class="mt-5 grid gap-4 xl:grid-cols-3">
                    <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                        <p class="text-sm font-semibold text-white">Default</p>
                        <p class="mt-2 text-sm text-slate-300">Baseline implementation state for {{ strtolower($catalogComponent['label']) }}.</p>
                    </div>
                    <div class="rounded-lg border border-sky-400 bg-slate-950/70 p-4 ring-2 ring-sky-400">
                        <p class="text-sm font-semibold text-white">Focus</p>
                        <p class="mt-2 text-sm text-slate-300">Visible focus ring and keyboard order must be reviewed.</p>
                    </div>
                    <div class="rounded-lg border border-slate-800 bg-slate-950/70 p-4 opacity-60">
                        <p class="text-sm font-semibold text-white">Disabled / unavailable</p>
                        <p class="mt-2 text-sm text-slate-300">Disabled treatment must preserve label readability.</p>
                    </div>
                </div>
            </section>
        @else
            <section class="ui-card" data-ui-reference-example="queued-gap-contract">
                <h2 class="ui-card-title">Queued Implementation Contract</h2>
                <p class="ui-card-copy mt-2">This Carbon-mapped item is intentionally visible in the Login App 2.0 catalog, but it does not receive speculative component chrome until a product consumer creates a concrete need.</p>
                <div class="mt-5 rounded-lg border border-slate-800 bg-slate-950/70 p-4">
                    <p class="text-sm font-semibold text-white">Trigger condition</p>
                    <p class="mt-2 text-sm text-slate-300">{{ $catalogComponent['guidance'][0] ?? 'Queue a component implementation when a feature requires this primitive.' }}</p>
                </div>
            </section>
        @endif
    </section>
</x-layouts.app>
