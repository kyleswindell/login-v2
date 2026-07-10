{{-- ==========================================================================
    File: Modules/Notifications/resources/views/header/partials/filters.blade.php
    Purpose: Notifications popover filter switcher.

    Notes:
    - Renders Unread / All notification filters.
    - Uses x-ui.content-switcher and x-ui.switch so selected, focus, and
      content-switcher styling remain component-owned.
    - The Unread count is rendered as a read-only Tag component.
    - This partial assumes notification state has been normalized by
      header/action.blade.php.
    ========================================================================== --}}

<div class="ui-shell-notifications-menu__filters">
    <x-ui.content-switcher
        size="sm"
        :low-contrast="true"
        selection-mode="automatic"
        aria-label="Notification filter"
        data-app-notifications-filter-switcher
        data-ui-content-switcher-fluid="true"
        data-ui-content-switcher-value="{{ $resolvedActiveFilter }}"
    >
        @foreach ($filterPanels as $filterValue => $filterPanel)
            @php
                /*
                |--------------------------------------------------------------------------
                | Filter State
                |--------------------------------------------------------------------------
                */

                $selected = $resolvedActiveFilter === $filterValue;
            @endphp

            <x-ui.switch
                id="{{ $filterPanel['tab_id'] }}"
                :index="$loop->index"
                :name="$filterValue"
                :selected="$selected"
                value="{{ $filterValue }}"
                aria-controls="{{ $filterPanel['panel_id'] }}"
                data-app-notifications-filter="{{ $filterValue }}"
                data-ui-content-switcher-value="{{ $filterValue }}"
                data-ui-content-switcher-text="{{ $filterPanel['label'] }}"
                data-ui-current="{{ $selected ? 'true' : 'false' }}"
            >
                <span>
                    {{
                        $filterPanel[
                            "label"
                        ]
                    }}
                </span>

                @if ($filterValue === "unread")
                    <x-ui.tag
                        variant="read-only"
                        type="high-contrast"
                        size="sm"
                        :text="(string) $resolvedUnreadCount"
                        class="ui-shell-notifications-menu__count-tag"
                        aria-hidden="true"
                        data-notification-filter-count-tag="unread"
                        data-notification-count-value="{{ $resolvedUnreadCount }}"
                        data-notification-count-empty="{{ $resolvedUnreadCount > 0 ? 'false' : 'true' }}"
                    />

                    <span
                        class="ui-assistive-text"
                        data-notification-filter-count-sr="unread"
                    >
                        {{
                            $resolvedUnreadCount === 1
                                ? "1 unread notification"
                                : $resolvedUnreadCount . " unread notifications"
                        }}
                    </span>
                @endif
            </x-ui.switch>
        @endforeach
    </x-ui.content-switcher>
</div>
