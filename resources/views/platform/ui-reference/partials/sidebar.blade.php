@php
    $currentSection = $currentSection ?? 'overview';
    $sidebarLinkClass = fn (bool $active, bool $compact = false) => trim('ui-reference-sidebar-link '.($compact ? 'ui-reference-sidebar-link-compact ' : '').($active ? 'is-current' : ''));
    $approvedComponentSlugs = ['button', 'tooltip'];
    $approvedElementSlugs = [];
    $statusBadgeLabel = fn (string $disposition) => match ($disposition) {
        'Partial' => 'Partial',
        'Needs audit' => 'Audit',
        'Deprecated' => 'Deprecated',
        'App-specific exception' => 'Exception',
        'Represent As Pattern' => 'Pattern',
        'Queued Gap' => 'Gap',
        default => 'Gate',
    };
@endphp

<aside class="w-full lg:w-72 lg:self-start">
    <div class="ui-reference-sidebar-panel" data-ui-reference-sidebar-scroll-owner="shell">
        <p class="ui-reference-sidebar-heading">UI Reference</p>

        <nav class="ui-reference-sidebar-nav" aria-label="UI Reference overview">
            @php $isOverviewCurrent = $currentSection === 'overview'; @endphp
            <a wire:navigate href="{{ route('platform.ui-reference.index') }}" class="{{ $sidebarLinkClass($isOverviewCurrent) }}" @if ($isOverviewCurrent) aria-current="page" @endif>
                <x-layouts.nav-icon icon="home" />
                <span>Overview</span>
            </a>
        </nav>

        <section
            class="ui-reference-sidebar-section ui-reference-sidebar-disclosure"
            data-ui-reference-sidebar-disclosure="foundation-elements"
            data-ui-reference-sidebar-disclosure-motion="productive"
            data-ui-reference-sidebar-disclosure-state="open"
        >
            <button
                type="button"
                class="ui-reference-sidebar-disclosure-trigger"
                aria-expanded="true"
                aria-controls="ui-reference-sidebar-foundation-elements-panel"
                data-ui-reference-sidebar-disclosure-trigger
            >
                <span>Foundation Elements</span>
                <x-heroicon-o-chevron-down class="ui-reference-sidebar-disclosure-icon" aria-hidden="true" data-ui-reference-sidebar-disclosure-icon />
            </button>

            <div
                id="ui-reference-sidebar-foundation-elements-panel"
                class="ui-reference-sidebar-disclosure-panel"
                data-ui-reference-sidebar-disclosure-panel
                data-ui-reference-sidebar-disclosure-state="open"
            >
                <nav class="ui-reference-sidebar-nav" aria-label="UI Reference foundation elements" data-ui-reference-element-sidebar>
                    @php $isElementsOverviewCurrent = $currentSection === 'elements.overview'; @endphp
                    <a wire:navigate href="{{ route('platform.ui-reference.elements.overview') }}" class="{{ $sidebarLinkClass($isElementsOverviewCurrent) }}" @if ($isElementsOverviewCurrent) aria-current="page" @endif>
                        <x-layouts.nav-icon icon="docs" />
                        <span>Overview</span>
                    </a>

                    @foreach (($elementCatalog ?? []) as $element)
                        @php
                            $isActiveElement = $currentSection === 'elements.'.$element['slug'];
                            $isColorTokenPage = $currentSection === 'elements.color.tokens';
                            $isTypographyTypeSetsPage = $currentSection === 'elements.typography.type-sets';
                            $isColorElement = $element['slug'] === 'color';
                            $isTypographyElement = $element['slug'] === 'typography';
                        @endphp

                        @if ($isColorElement)
                            @php $isColorOpen = $isActiveElement || $isColorTokenPage; @endphp
                            <section
                                class="ui-reference-sidebar-disclosure"
                                data-ui-reference-element-sidebar-item="color"
                                data-ui-reference-element-dropdown="color"
                                data-ui-reference-element-dropdown-open="{{ $isColorOpen ? 'true' : 'false' }}"
                                data-ui-reference-sidebar-disclosure="color"
                                data-ui-reference-sidebar-disclosure-motion="productive"
                                data-ui-reference-sidebar-disclosure-state="{{ $isColorOpen ? 'open' : 'closed' }}"
                            >
                                <button
                                    type="button"
                                    class="ui-reference-sidebar-disclosure-trigger ui-reference-sidebar-disclosure-trigger-item {{ $isColorOpen ? 'is-current' : '' }}"
                                    aria-expanded="{{ $isColorOpen ? 'true' : 'false' }}"
                                    aria-controls="ui-reference-sidebar-color-panel"
                                    data-ui-reference-sidebar-disclosure-trigger
                                >
                                    <span>{{ $element['label'] }}</span>
                                    <x-heroicon-o-chevron-down class="ui-reference-sidebar-disclosure-icon" aria-hidden="true" data-ui-reference-sidebar-disclosure-icon />
                                </button>

                                <div
                                    id="ui-reference-sidebar-color-panel"
                                    class="ui-reference-sidebar-disclosure-panel"
                                    data-ui-reference-sidebar-disclosure-panel
                                    data-ui-reference-sidebar-disclosure-state="{{ $isColorOpen ? 'open' : 'closed' }}"
                                    @unless ($isColorOpen) hidden @endunless
                                >
                                    <nav class="ui-reference-sidebar-nested-nav" aria-label="UI Reference color" data-ui-reference-color-sidebar>
                                        <a wire:navigate href="{{ route('platform.ui-reference.elements.show', ['element' => 'color']) }}" class="{{ $sidebarLinkClass($isActiveElement, true) }}" data-ui-reference-color-sidebar-item="overview" @if ($isActiveElement) aria-current="page" @endif>Overview</a>
                                        <a wire:navigate href="{{ route('platform.ui-reference.elements.color.tokens') }}" class="{{ $sidebarLinkClass($isColorTokenPage, true) }}" data-ui-reference-color-sidebar-item="token-palette" @if ($isColorTokenPage) aria-current="page" @endif>Token Palette</a>
                                    </nav>
                                </div>
                            </section>
                        @elseif ($isTypographyElement)
                            @php $isTypographyOpen = $isActiveElement || $isTypographyTypeSetsPage; @endphp
                            <section
                                class="ui-reference-sidebar-disclosure"
                                data-ui-reference-element-sidebar-item="typography"
                                data-ui-reference-element-dropdown="typography"
                                data-ui-reference-element-dropdown-open="{{ $isTypographyOpen ? 'true' : 'false' }}"
                                data-ui-reference-sidebar-disclosure="typography"
                                data-ui-reference-sidebar-disclosure-motion="productive"
                                data-ui-reference-sidebar-disclosure-state="{{ $isTypographyOpen ? 'open' : 'closed' }}"
                            >
                                <button
                                    type="button"
                                    class="ui-reference-sidebar-disclosure-trigger ui-reference-sidebar-disclosure-trigger-item {{ $isTypographyOpen ? 'is-current' : '' }}"
                                    aria-expanded="{{ $isTypographyOpen ? 'true' : 'false' }}"
                                    aria-controls="ui-reference-sidebar-typography-panel"
                                    data-ui-reference-sidebar-disclosure-trigger
                                >
                                    <span>{{ $element['label'] }}</span>
                                    <x-heroicon-o-chevron-down class="ui-reference-sidebar-disclosure-icon" aria-hidden="true" data-ui-reference-sidebar-disclosure-icon />
                                </button>

                                <div
                                    id="ui-reference-sidebar-typography-panel"
                                    class="ui-reference-sidebar-disclosure-panel"
                                    data-ui-reference-sidebar-disclosure-panel
                                    data-ui-reference-sidebar-disclosure-state="{{ $isTypographyOpen ? 'open' : 'closed' }}"
                                    @unless ($isTypographyOpen) hidden @endunless
                                >
                                    <nav class="ui-reference-sidebar-nested-nav" aria-label="UI Reference typography" data-ui-reference-typography-sidebar>
                                        <a wire:navigate href="{{ route('platform.ui-reference.elements.show', ['element' => 'typography']) }}" class="{{ $sidebarLinkClass($isActiveElement, true) }}" data-ui-reference-typography-sidebar-item="overview" @if ($isActiveElement) aria-current="page" @endif>Overview</a>
                                        <a wire:navigate href="{{ route('platform.ui-reference.elements.typography.type-sets') }}" class="{{ $sidebarLinkClass($isTypographyTypeSetsPage, true) }}" data-ui-reference-typography-sidebar-item="type-sets" @if ($isTypographyTypeSetsPage) aria-current="page" @endif>Type Sets</a>
                                    </nav>
                                </div>
                            </section>
                        @else
                            <a wire:navigate href="{{ route('platform.ui-reference.elements.show', ['element' => $element['slug']]) }}" class="{{ $sidebarLinkClass($isActiveElement) }}" data-ui-reference-element-sidebar-item="{{ $element['slug'] }}" @if ($isActiveElement) aria-current="page" @endif>
                                <span>{{ $element['label'] }}</span>
                                @if (in_array($element['slug'], $approvedElementSlugs, true))
                                    <span class="ui-reference-sidebar-approved-badge" role="img" aria-label="Approved" title="Approved" data-ui-reference-sidebar-approved="element:{{ $element['slug'] }}">
                                        <x-heroicon-o-check-circle aria-hidden="true" />
                                    </span>
                                @endif
                                @if ($element['disposition'] !== 'Implemented')
                                    <span class="ui-reference-sidebar-badge">{{ $statusBadgeLabel($element['disposition']) }}</span>
                                @endif
                            </a>
                        @endif
                    @endforeach
                </nav>
            </div>
        </section>

        <section
            class="ui-reference-sidebar-section ui-reference-sidebar-disclosure"
            data-ui-reference-sidebar-disclosure="components"
            data-ui-reference-sidebar-disclosure-motion="productive"
            data-ui-reference-sidebar-disclosure-state="open"
        >
            <button
                type="button"
                class="ui-reference-sidebar-disclosure-trigger"
                aria-expanded="true"
                aria-controls="ui-reference-sidebar-components-panel"
                data-ui-reference-sidebar-disclosure-trigger
            >
                <span>Components</span>
                <x-heroicon-o-chevron-down class="ui-reference-sidebar-disclosure-icon" aria-hidden="true" data-ui-reference-sidebar-disclosure-icon />
            </button>

            <div
                id="ui-reference-sidebar-components-panel"
                class="ui-reference-sidebar-disclosure-panel"
                data-ui-reference-sidebar-disclosure-panel
                data-ui-reference-sidebar-disclosure-state="open"
            >
                <nav class="ui-reference-sidebar-nav" aria-label="UI Reference components" data-ui-reference-component-sidebar data-ui-reference-component-sidebar-sort="alphabetical">
                    @php $isComponentsOverviewCurrent = $currentSection === 'components.overview'; @endphp
                    <a wire:navigate href="{{ route('platform.ui-reference.components.overview') }}" class="{{ $sidebarLinkClass($isComponentsOverviewCurrent) }}" @if ($isComponentsOverviewCurrent) aria-current="page" @endif>
                        <x-layouts.nav-icon icon="docs" />
                        <span>Overview</span>
                    </a>

                    @foreach (collect($componentCatalog ?? [])->sortBy('label', SORT_NATURAL | SORT_FLAG_CASE) as $component)
                        @php $isActiveComponent = $currentSection === 'components.'.$component['slug']; @endphp
                        <a wire:navigate href="{{ route('platform.ui-reference.components.show', ['component' => $component['slug']]) }}" class="{{ $sidebarLinkClass($isActiveComponent) }}" data-ui-reference-component-sidebar-item="{{ $component['slug'] }}" data-ui-reference-component-sidebar-label="{{ $component['label'] }}" @if ($isActiveComponent) aria-current="page" @endif>
                            <span>{{ $component['label'] }}</span>
                            @if (in_array($component['slug'], $approvedComponentSlugs, true))
                                <span class="ui-reference-sidebar-approved-badge" role="img" aria-label="Approved" title="Approved" data-ui-reference-sidebar-approved="component:{{ $component['slug'] }}">
                                    <x-heroicon-o-check-circle aria-hidden="true" />
                                </span>
                            @endif
                            @if ($component['disposition'] !== 'Implement Component Page')
                                <span class="ui-reference-sidebar-badge">{{ $statusBadgeLabel($component['disposition']) }}</span>
                            @endif
                        </a>
                    @endforeach
                </nav>
            </div>
        </section>

        <section class="ui-reference-sidebar-section">
            <p class="ui-reference-sidebar-heading">Patterns</p>
            <nav class="ui-reference-sidebar-nav" aria-label="UI Reference patterns">
                @foreach ([
                    ['patterns.forms', route('platform.ui-reference.patterns.forms'), 'docs', 'Form Patterns'],
                    ['patterns.data-content', route('platform.ui-reference.patterns.data-content'), 'users', 'Data + Content'],
                    ['patterns.tables', route('platform.ui-reference.patterns.tables'), 'users', 'Table Baselines'],
                    ['patterns.overlays', route('platform.ui-reference.patterns.overlays'), 'error-log', 'Overlays + Feedback'],
                    ['patterns.navigation', route('platform.ui-reference.patterns.navigation'), 'home', 'Navigation + Actions'],
                    ['patterns.layout', route('platform.ui-reference.patterns.layout'), 'settings', 'Layout + Dashboard'],
                ] as [$section, $href, $icon, $label])
                    @php $isPatternCurrent = $currentSection === $section; @endphp
                    <a wire:navigate href="{{ $href }}" class="{{ $sidebarLinkClass($isPatternCurrent) }}" @if ($isPatternCurrent) aria-current="page" @endif>
                        <x-layouts.nav-icon :icon="$icon" />
                        <span>{{ $label }}</span>
                    </a>
                @endforeach

                @php $isWidgetContentSection = str_starts_with($currentSection, 'patterns.widget-content'); @endphp
                <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content') }}" class="{{ $sidebarLinkClass($isWidgetContentSection) }}" @if ($currentSection === 'patterns.widget-content') aria-current="page" @endif>
                    <x-layouts.nav-icon icon="settings" />
                    <span>Widget Content</span>
                </a>
                @if ($isWidgetContentSection)
                    <nav class="ui-reference-sidebar-nested-nav" aria-label="UI Reference widget content">
                        @foreach ([
                            ['shape-map', 'Shape Map'],
                            ['1x1', '1x1'],
                            ['2x1', '2x1'],
                            ['1x2', '1x2'],
                            ['2x2', '2x2'],
                            ['3x1', '3x1'],
                            ['3x2', '3x2'],
                            ['3x3', '3x3'],
                            ['4x0-5', '4x0.5 Strip'],
                        ] as [$slug, $label])
                            @php $isWidgetSizeCurrent = $currentSection === 'patterns.widget-content.'.$slug; @endphp
                            <a wire:navigate href="{{ route('platform.ui-reference.patterns.widget-content.size', ['size' => $slug]) }}" class="{{ $sidebarLinkClass($isWidgetSizeCurrent, true) }}" @if ($isWidgetSizeCurrent) aria-current="page" @endif>{{ $label }}</a>
                        @endforeach
                    </nav>
                @endif

                @foreach ([
                    ['patterns.starters', route('platform.ui-reference.patterns.starters'), 'docs', 'Starter Catalog'],
                    ['patterns.archetypes', route('platform.ui-reference.patterns.archetypes'), 'audit-log', 'Archetype Proofs'],
                ] as [$section, $href, $icon, $label])
                    @php $isPatternCurrent = $currentSection === $section; @endphp
                    <a wire:navigate href="{{ $href }}" class="{{ $sidebarLinkClass($isPatternCurrent) }}" @if ($isPatternCurrent) aria-current="page" @endif>
                        <x-layouts.nav-icon :icon="$icon" />
                        <span>{{ $label }}</span>
                    </a>
                @endforeach
            </nav>
        </section>
    </div>
</aside>
