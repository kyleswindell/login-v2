# Authentication

## Current Scope

App 2.0 starts with a minimal first-party sign-in and sign-out flow.

Implemented routes:

* `GET /login`
* `POST /login`
* `GET /dashboard`
* `POST /logout`

Implemented Laravel pieces:

* `App\Http\Controllers\Auth\LoginController`
* `App\Http\Requests\Auth\LoginRequest`
* guest middleware around login routes
* auth middleware around dashboard/logout routes

Related docs:

* [[V2 App/Features/Event And Error Logging]] | [Event And Error Logging](Event%20And%20Error%20Logging.md)
* [[Standards/Logging Standards]] | [Logging Standards](../../Standards/Logging%20Standards.md)
* [[Standards/Commenting Standards]] | [Commenting Standards](../../Standards/Commenting%20Standards.md)

## Current Behavior

* Guests can view the login form.
* Guests are redirected to `/login` if they request `/dashboard`.
* Authenticated users are redirected away from `/login`.
* Authenticated users can view the dashboard.
* Successful login regenerates the session.
* Logout invalidates the session and regenerates the CSRF token.
* Login success, login failure, and logout write platform audit events.
* Login validation is handled by a dedicated form request instead of inline controller rules.

## Near-Term Notes

This is intentionally not a full user-management or password-reset system yet. Filament panel authentication and tenant-specific authentication should be added after the platform/tenant boundary is clearer.

## Related

* [[V2 App/Features/Feature Index]] | [Feature Index](Feature%20Index.md)
* [[V2 App/V2 App Documentation Map]] | [V2 App Documentation Map](../V2%20App%20Documentation%20Map.md)
* [[V2 App/Reference/Stack - Laravel]] | [Stack - Laravel](../Reference/Stack%20-%20Laravel.md)
