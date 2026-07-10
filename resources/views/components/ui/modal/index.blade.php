{{-- ==========================================================================
    File: resources/views/components/ui/modal/index.blade.php
    Purpose: Modal component.

    Source: Composed from the app-owned x-ui.dialog.* primitive family and
    Carbon Modal API concepts.

    Notes:
    - ModalWrapper is deprecated in Carbon and is not ported.
    - Modal is a higher-level Blade API built on native x-ui.dialog.root.
    - Triggers are external elements using data-ui-dialog-trigger,
      data-ui-dialog-open-trigger, aria-controls, or href="#{id}".
    - Supports passive modals, transactional modals, sizes, close button,
      generated footer/actions, custom footer slots, backdrop dismissal,
      scroll-content treatment, and focus management.
    - JavaScript behavior is owned by resources/js/ui-controls/dialog.js.
    - resources/js/ui-controls/modal.js should not be used by this component.
    ========================================================================== --}}

@php
    /*
    |--------------------------------------------------------------------------
    | Component Setup
    |--------------------------------------------------------------------------
    */

    $componentPath = resource_path('views/components/ui/modal');
    $propDefaults = require $componentPath.'/props.php';
    $modalOptions = require $componentPath.'/options.php';
@endphp

@props ($propDefaults)

@php
    /*
    |--------------------------------------------------------------------------
    | View Model
    |--------------------------------------------------------------------------
    */

    $view = (require $componentPath.'/view-model.php')(
        [
            'id' => $id,

            'titleId' => $titleId,
            'title' => $title,
            'modalHeading' => $modalHeading,
            'label' => $label,
            'modalLabel' => $modalLabel,
            'kicker' => $kicker,
            'description' => $description,
            'modalAriaLabel' => $modalAriaLabel,
            'closeButtonLabel' => $closeButtonLabel,

            'open' => $open,
            'variant' => $variant,
            'passiveModal' => $passiveModal,
            'closeOnBackdrop' => $closeOnBackdrop,
            'preventCloseOnClickOutside' => $preventCloseOnClickOutside,
            'shouldSubmitOnEnter' => $shouldSubmitOnEnter,
            'selectorPrimaryFocus' => $selectorPrimaryFocus,

            'size' => $size,
            'danger' => $danger,
            'alert' => $alert,
            'hasScrollingContent' => $hasScrollingContent,
            'isFullWidth' => $isFullWidth,

            'primaryButtonText' => $primaryButtonText,
            'primaryButtonKind' => $primaryButtonKind,
            'primaryButtonType' => $primaryButtonType,
            'primaryButtonHref' => $primaryButtonHref,
            'primaryButtonForm' => $primaryButtonForm,
            'primaryButtonName' => $primaryButtonName,
            'primaryButtonValue' => $primaryButtonValue,
            'primaryButtonDisabled' => $primaryButtonDisabled,
            'primaryButtonLoading' => $primaryButtonLoading,

            'secondaryButtonText' => $secondaryButtonText,
            'secondaryButtonKind' => $secondaryButtonKind,
            'secondaryButtonType' => $secondaryButtonType,
            'secondaryButtonHref' => $secondaryButtonHref,
            'secondaryButtonForm' => $secondaryButtonForm,
            'secondaryButtonName' => $secondaryButtonName,
            'secondaryButtonValue' => $secondaryButtonValue,
            'secondaryButtonDisabled' => $secondaryButtonDisabled,
            'secondaryButtons' => $secondaryButtons,

            'shouldCloseAfterSubmit' => $shouldCloseAfterSubmit,
        ],
        $attributes,
        $modalOptions,
    );

    $hasFooterSlot = isset($footer);
    $hasActionsSlot = isset($actions);
    $showsFooter = ! $view["resolvedPassive"]
        && ($hasFooterSlot || $hasActionsSlot || $view["hasGeneratedFooter"]);
@endphp

<x-ui.dialog.root
    id="{{ $view['resolvedId'] }}"
    :modal="true"
    :open="$view['resolvedOpen']"
    :role="$view['resolvedRole']"
    :label="$view['resolvedAriaLabel']"
    :labelledby="$view['ariaLabelledBy']"
    :describedby="$view['resolvedDescribedBy']"
    :extra-attributes="$view['rootAttributes']"
    :container-attributes="$view['containerAttributes']"
>
    <x-ui.dialog.header
        :extra-attributes="$view['headerAttributes']"
    >
        @if ($view["resolvedLabel"])
            <x-ui.dialog.subtitle
                tag="p"
                id="{{ $view['resolvedLabelId'] }}"
                class="{{ $view['modalClasses']['header_label'] }}"
            >
                {{ $view["resolvedLabel"] }}
            </x-ui.dialog.subtitle>
        @endif

        @if ($view["resolvedTitle"])
            <x-ui.dialog.title
                id="{{ $view['resolvedTitleId'] }}"
                class="{{ $view['modalClasses']['header_heading'] }}"
            >
                {{ $view["resolvedTitle"] }}
            </x-ui.dialog.title>
        @endif

        <x-ui.dialog.controls
            class="{{ $view['modalClasses']['close_button_wrapper'] }}"
        >
            <x-ui.dialog.close-button
                class="{{ $view['modalClasses']['close_button'] }}"
                :label="$closeButtonLabel"
            >
                <x-ui.icon
                    name="close"
                    class="{{ $view['modalClasses']['close_icon'] }}"
                    width="20"
                    height="20"
                    aria-hidden="true"
                    focusable="false"
                />
            </x-ui.dialog.close-button>
        </x-ui.dialog.controls>
    </x-ui.dialog.header>

    <x-ui.dialog.body
        :has-scrolling-content="$view['resolvedScrolling']"
        :labelledby="$view['ariaLabelledBy']"
        :ariaLabel="$view['resolvedAriaLabel']"
        :extra-attributes="$view['contentAttributes']"
    >
        @if ($description)
            <p class="{{ $view['modalClasses']['description'] }}">
                {{
                    $description
                }}
            </p>
        @endif

        {{ $slot }}
    </x-ui.dialog.body>

    @if ($showsFooter)
        <x-ui.dialog.footer
            :three-button="$view['hasThreeButtonFooter']"
            :busy="$view['resolvedPrimaryLoading']"
            :extra-attributes="$view['footerAttributes']"
        >
            @if ($hasFooterSlot)
                {{
                    $footer
                }}
            @elseif ($hasActionsSlot)
                {{
                    $actions
                }}
            @else
                @foreach ($view["resolvedSecondaryButtons"] as $action)
                    <x-ui.button
                        :type="$action['type']"
                        :kind="$action['kind']"
                        :disabled="$action['disabled']"
                        :href="$action['href']"
                        :form="$action['form']"
                        :name="$action['name']"
                        :value="$action['value']"
                        data-ui-dialog-secondary="true"
                        data-ui-dialog-close="{{ $action['close'] ? 'true' : 'false' }}"
                        data-ui-dialog-primary-focus="{{ $action['primaryFocus'] ? 'true' : 'false' }}"
                        data-ui-form-action="true"
                        data-ui-form-action-role="secondary"
                        data-ui-form-action-allow-during-busy="false"
                    >
                        {{
                            $action[
                                "label"
                            ]
                        }}
                    </x-ui.button>
                @endforeach

                @if ($view["hasGeneratedPrimary"])
                    <x-ui.button
                        :href="$primaryButtonHref"
                        :type="$view['resolvedPrimaryType']"
                        :kind="$view['resolvedPrimaryKind']"
                        :disabled="$view['resolvedPrimaryDisabled']"
                        :loading="$view['resolvedPrimaryLoading']"
                        :form="$primaryButtonForm"
                        :name="$primaryButtonName"
                        :value="$primaryButtonValue"
                        data-ui-dialog-primary="true"
                        data-ui-dialog-primary-focus="{{ $view['primaryShouldReceiveFocus'] ? 'true' : 'false' }}"
                        data-ui-form-action="true"
                        data-ui-form-action-role="submit"
                        data-ui-form-action-allow-during-busy="false"
                    >
                        {{
                            $primaryButtonText
                        }}
                    </x-ui.button>
                @endif
            @endif
        </x-ui.dialog.footer>
    @endif
</x-ui.dialog.root>
