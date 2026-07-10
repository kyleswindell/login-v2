@if (session('status'))
    <x-ui.notification.inline kind="success" :title="session('status')" />
@endif

@if (session('auth_notice'))
    <x-ui.notification.inline kind="warning" :title="session('auth_notice')" />
@endif

@if ($errors->has('auth'))
    <x-ui.notification.inline kind="error" :title="$errors->first('auth')" />
@endif

@if (session('auth_session_expired'))
    <x-ui.modal
        id="auth-session-expired"
        title="Session expired"
        description="The previous sign-in session expired. Start again to continue."
        variant="passive"
        size="sm"
        :open="true"
    />
@endif
