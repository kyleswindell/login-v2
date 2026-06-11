@php
    $menuItems = [
        ['label' => 'Workspace', 'action' => 'create-workspace'],
        ['label' => 'Tenant', 'action' => 'create-tenant'],
        ['label' => 'Invite', 'action' => 'create-invite'],
    ];

    $rowItems = [
        ['label' => 'View details', 'href' => '#'],
        ['label' => 'Rename', 'action' => 'rename-workspace'],
        ['divider' => true],
        ['label' => 'Archive workspace', 'action' => 'archive-workspace', 'danger' => true],
    ];

    $comboItems = [
        ['label' => 'Save and close', 'action' => 'save-close'],
        ['label' => 'Save as draft', 'action' => 'save-draft'],
        ['label' => 'Schedule publish', 'action' => 'schedule-publish'],
    ];

    $sizeRows = [
        ['Extra small', '24px / 1.5rem', 'xs'],
        ['Small', '32px / 2rem', 'sm'],
        ['Medium', '40px / 2.5rem', 'md'],
        ['Large', '48px / 3rem', 'lg'],
    ];

    $variantRows = [
        ['Menu button', 'x-ui.menu-button', 'Use when all menu actions share the same level of importance, usually in page headers.', 'Approved API'],
        ['Combo button', 'x-ui.combo-button', 'Use when one action has primary importance and related alternate actions need to stay nearby.', 'Approved API'],
        ['Overflow menu', 'x-ui.overflow-menu', 'Use when additional row, card, or toolbar options are available in constrained space.', 'Approved API'],
    ];

    $triggerRows = [
        ['Primary menu button', 'Strongest local menu action group.', '<x-ui.menu-button type="primary" label="Create" :items="$menuItems" />'],
        ['Tertiary menu button', 'Visible but not primary action group.', '<x-ui.menu-button type="tertiary" label="Actions" :items="$menuItems" />'],
        ['Ghost menu button', 'Low-emphasis toolbar or header action group.', '<x-ui.menu-button type="ghost" label="More actions" :items="$menuItems" />'],
        ['Combo primary only', 'Primary action paired with a separate menu trigger.', '<x-ui.combo-button label="Save" menu-label="Save options" :items="$comboItems" />'],
        ['Overflow ghost only', 'Icon-only trigger for constrained row/card actions.', '<x-ui.overflow-menu label="Workspace actions" :items="$rowItems" />'],
    ];
@endphp

<div class="space-y-6" data-component-live-layout="menu-buttons-matrix">
    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-menu-buttons-live-section="variant-purpose-matrix">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Variant purpose matrix</h3>
        <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">Menu buttons are action revealers. They are not value selectors, navigation, or rich-content popovers.</p>
        <div class="mt-4 overflow-x-auto rounded-lg border" style="border-color: var(--ui-border-subtle-01);">
            <table class="min-w-full text-left text-sm">
                <thead style="background-color: var(--ui-layer-accent-01); color: var(--ui-text-secondary);">
                    <tr>
                        <th class="px-4 py-3">Variant</th>
                        <th class="px-4 py-3">API</th>
                        <th class="px-4 py-3">Purpose</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($variantRows as [$variant, $api, $purpose, $status])
                        <tr class="border-t" style="border-color: var(--ui-border-subtle-01);" data-menu-buttons-variant-row="{{ Str::slug($variant) }}">
                            <td class="px-4 py-3 font-semibold" style="color: var(--ui-text-primary);">{{ $variant }}</td>
                            <td class="px-4 py-3"><code>{{ $api }}</code></td>
                            <td class="max-w-xl px-4 py-3 leading-6" style="color: var(--ui-text-secondary);">{{ $purpose }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center rounded-full border px-2 py-0.5 text-xs font-semibold" style="border-color: var(--ui-border-subtle-01); color: var(--ui-text-secondary);">{{ $status }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-menu-buttons-live-section="base-options">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Base options</h3>
        <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">Base examples start closed and can be interacted with. Open-state proof is separated so reference text stays readable.</p>
        <div class="mt-4 grid gap-4 xl:grid-cols-3">
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-menu-buttons-base="menu-button">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Menu button</h4>
                <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">A labeled button opens an equal-importance action list.</p>
                <div class="mt-4">
                    <x-ui.menu-button label="Create" type="primary" :items="$menuItems" />
                </div>
            </article>
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-menu-buttons-base="combo-button">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Combo button</h4>
                <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">The primary action remains visible; alternates sit behind the menu trigger.</p>
                <div class="mt-4">
                    <x-ui.combo-button label="Save" menu-label="Save options" :items="$comboItems" />
                </div>
            </article>
            <article class="rounded-md border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-menu-buttons-base="overflow-menu">
                <h4 class="text-sm font-semibold" style="color: var(--ui-text-primary);">Overflow menu</h4>
                <p class="mt-2 text-sm leading-6" style="color: var(--ui-text-secondary);">Icon-only row or card trigger with an object-specific accessible name.</p>
                <div class="mt-4">
                    <x-ui.overflow-menu label="Workspace actions" aria-label="Workspace alpha actions" tooltip="Workspace actions" :items="$rowItems" />
                </div>
            </article>
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-menu-buttons-live-section="trigger-style-matrix">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Trigger style matrix</h3>
        <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">The trigger style communicates action hierarchy. Do not use trigger style as decoration. Menu button triggers follow Button style guidance and consume the same Button-owned action tokens rather than defining a local menu-trigger palette.</p>
        <div class="mt-4 grid gap-3 lg:grid-cols-2">
            @foreach ($triggerRows as [$label, $purpose, $example])
                <article class="rounded-md border p-3" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-menu-buttons-trigger-row="{{ Str::slug($label) }}">
                    <p class="text-sm font-semibold" style="color: var(--ui-text-primary);">{{ $label }}</p>
                    <p class="mt-1 text-sm leading-6" style="color: var(--ui-text-secondary);">{{ $purpose }}</p>
                    <div class="mt-3">{!! Blade::render($example, compact('menuItems', 'comboItems', 'rowItems')) !!}</div>
                </article>
            @endforeach
        </div>
    </section>

    <section class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-menu-buttons-live-section="size-scale">
        <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Size scale</h3>
        <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">Trigger height and menu item height use the same size. Menus keep a readable minimum width of at least 160px.</p>
        <div class="mt-4 grid gap-3">
            @foreach ($sizeRows as [$label, $height, $size])
                <div class="grid gap-3 rounded-md border p-3 xl:grid-cols-[9rem_8rem_minmax(0,0.8fr)_minmax(14rem,1fr)] xl:items-start" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-02);" data-menu-buttons-size-row="{{ Str::slug($label) }}">
                    <div>
                        <p class="font-semibold" style="color: var(--ui-text-primary);">{{ $label }}</p>
                        <p class="mt-1 text-xs" style="color: var(--ui-text-helper);">{{ $height }}</p>
                    </div>
                    <x-ui.menu-button label="Actions" type="tertiary" :size="$size" :items="$menuItems" />
                    <div class="ui-menu ui-menu-{{ $size }} ui-menu-proof-panel !mt-0" role="menu" data-menu-buttons-size-proof="{{ $size }}" data-ui-menu-proof-panel>
                        <x-ui.menu-item :size="$size">Open details</x-ui.menu-item>
                        <x-ui.menu-item :size="$size" shortcut="⌘K">Keyboard shortcut</x-ui.menu-item>
                    </div>
                    <p class="text-sm leading-6" style="color: var(--ui-text-secondary);">Closed trigger plus static item-height proof. This avoids forced-open overlays on the reference page.</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="grid gap-4 xl:grid-cols-2">
        <article class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-menu-buttons-live-section="placement-width">
            <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Placement and width behavior</h3>
            <p class="mt-2 text-sm" style="color: var(--ui-text-secondary);">Menus use readable minimum width, support edge placement, and keep ghost triggers sized to the button rather than stretching to menu width.</p>
            <div class="mt-4 grid gap-3">
                <div data-menu-buttons-width-rule="minimum-160">
                    <x-ui.menu-button label="Bottom end" type="tertiary" placement="bottom-end" :items="$menuItems" />
                    <p class="mt-2 text-xs" style="color: var(--ui-text-helper);">Menu minimum width: 160px or wider through the app menu surface.</p>
                </div>
                <div data-menu-buttons-width-rule="ghost-exception">
                    <x-ui.menu-button label="Ghost trigger" type="ghost" placement="bottom-start" :items="$menuItems" />
                    <p class="mt-2 text-xs" style="color: var(--ui-text-helper);">Ghost trigger width follows the button; the menu still keeps readable width.</p>
                </div>
            </div>
        </article>

        <article class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-menu-buttons-live-section="states-keyboard">
            <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">States and keyboard behavior</h3>
            <div class="mt-4 grid gap-3">
                <div class="flex flex-wrap gap-3">
                    <x-ui.menu-button label="Disabled actions" type="tertiary" :items="$menuItems" disabled />
                    <x-ui.menu-button label="Loading actions" type="tertiary" :items="$menuItems" loading />
                    <x-ui.menu-button label="Open proof" type="tertiary" :items="$menuItems" open />
                </div>
                <ul class="space-y-2 text-sm leading-6" style="color: var(--ui-text-secondary);">
                    <li data-menu-buttons-keyboard-rule="aria-expanded">Open triggers set <code>aria-expanded="true"</code> and closed triggers set <code>aria-expanded="false"</code>.</li>
                    <li data-menu-buttons-keyboard-rule="escape">Escape closes the menu and returns focus to the trigger.</li>
                    <li data-menu-buttons-keyboard-rule="arrows">Up and Down arrows move item focus through the Menu API.</li>
                    <li data-menu-buttons-keyboard-rule="activate">Enter or Space activates the focused item.</li>
                </ul>
            </div>
        </article>
    </section>

    <section class="grid gap-4 xl:grid-cols-2">
        <article class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-menu-buttons-live-section="content-boundaries">
            <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Content and boundary rules</h3>
            <ul class="mt-3 space-y-2 text-sm leading-6" style="color: var(--ui-text-secondary);">
                <li>Use a shared verb trigger when menu items are objects for that action, such as Create / Workspace / Tenant / Invite.</li>
                <li>Use Actions only when grouped actions are distinct and no clearer shared label exists.</li>
                <li>Overflow accessible labels must name the object or region.</li>
                <li data-menu-buttons-boundary="not-value-selection">Menu buttons are for actions, not value selection. Use Dropdown, Select, or Multiselect for values.</li>
                <li data-menu-buttons-boundary="not-rich-content">Use Popover or Modal for forms, checkboxes, filters, and rich controls.</li>
            </ul>
        </article>

        <article class="rounded-lg border p-4" style="border-color: var(--ui-border-subtle-01); background-color: var(--ui-layer-01);" data-menu-buttons-live-section="developer-implementation">
            <h3 class="text-base font-semibold" style="color: var(--ui-text-primary);">Developer implementation examples</h3>
            <div class="mt-4 grid gap-3">
                <x-ui.code-snippet language="Blade" copyable><span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.menu-button</span> <span class="ui-code-token-property">label</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"Create"</span> <span class="ui-code-token-property">type</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"primary"</span> <span class="ui-code-token-property">:items</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"$items"</span> <span class="ui-code-token-punctuation">/&gt;</span></x-ui.code-snippet>
                <x-ui.code-snippet language="Blade" copyable><span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.combo-button</span> <span class="ui-code-token-property">label</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"Save"</span> <span class="ui-code-token-property">menu-label</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"Save options"</span> <span class="ui-code-token-property">:items</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"$items"</span> <span class="ui-code-token-punctuation">/&gt;</span></x-ui.code-snippet>
                <x-ui.code-snippet language="Blade" copyable><span class="ui-code-token-punctuation">&lt;</span><span class="ui-code-token-keyword">x-ui.overflow-menu</span> <span class="ui-code-token-property">label</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"Workspace actions"</span> <span class="ui-code-token-property">aria-label</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"Workspace alpha actions"</span> <span class="ui-code-token-property">:items</span><span class="ui-code-token-punctuation">=</span><span class="ui-code-token-string">"$items"</span> <span class="ui-code-token-punctuation">/&gt;</span></x-ui.code-snippet>
            </div>
        </article>
    </section>
</div>
