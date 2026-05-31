<div {{ $attributes->class(['ui-pattern-form-actions']) }} data-ui-pattern="form-actions-bar">
    @isset($leading)
        <div class="ui-pattern-form-actions-leading">
            {{ $leading }}
        </div>
    @endisset

    <div class="ui-pattern-form-actions-trailing">
        {{ $slot }}
    </div>
</div>
