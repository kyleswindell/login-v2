<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Auth\Notifications\Types as AuthNotificationTypes;
use App\Modules\Roles\Services\AssignmentGuard;
use App\Modules\Auth\Services\Mfa\MfaAssurance;
use App\Modules\Auth\Services\Mfa\MfaManager;
use App\Modules\Auth\Services\Mfa\MfaStepUpGuard;
use App\Modules\Notifications\Services\Notifier;
use App\Platform\Logging\PlatformLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PlatformUserMfaController extends Controller
{
    public function __construct(
        private readonly MfaAssurance $assurance,
        private readonly MfaManager $mfaManager,
        private readonly MfaStepUpGuard $mfaStepUpGuard,
        private readonly PlatformLogger $logger,
        private readonly Notifier $notifier,
    ) {}

    public function updateRequirement(Request $request, User $user): RedirectResponse
    {
        $this->authorize('manage-platform-users');
        abort_unless(app(AssignmentGuard::class)->canManageTarget($request->user(), $user), 403);

        $validated = $request->validate([
            'mfa_required' => ['required', 'boolean'],
        ]);

        $actor = $request->user();
        $required = (bool) $validated['mfa_required'];

        $user->mfaPolicy()->updateOrCreate([], [
            'mfa_required' => $required,
            'required_at' => $required ? now() : null,
            'required_by_user_id' => $required ? $actor?->id : null,
            'updated_by_user_id' => $actor?->id,
        ]);

        $this->logger->recordEvent(
            'auth.mfa_requirement_updated',
            [
                'user_id' => $user->id,
                'mfa_required' => $required,
            ],
            actorUserId: $actor?->id,
            subjectType: User::class,
            subjectId: (string) $user->id,
            isSecurityEvent: true,
        );

        return back()->with('status', $required ? 'MFA requirement enabled.' : 'MFA requirement disabled.');
    }

    public function reset(Request $request, User $user): RedirectResponse
    {
        $this->authorize('manage-platform-users');
        abort_unless(app(AssignmentGuard::class)->canManageTarget($request->user(), $user), 403);

        /** @var User $actor */
        $actor = $request->user();

        if ($this->mfaStepUpGuard->requiresEnrollment($actor)) {
            return redirect()
                ->route('platform.account.mfa.enroll')
                ->withErrors(['code' => 'MFA enrollment is required before resetting MFA enrollment.']);
        }

        if ($this->mfaStepUpGuard->requiresFreshMfa($request, $actor)) {
            return $this->mfaStepUpGuard->redirectToChallenge(
                $request,
                route('platform.users.edit', $user, absolute: false),
                'Verify MFA before resetting MFA enrollment.',
            );
        }

        $this->mfaManager->resetMfa($user, $actor);

        if ($actor->is($user)) {
            $this->assurance->clearSatisfied($request);
        }

        $this->logger->recordEvent(
            'auth.mfa_reset',
            [
                'user_id' => $user->id,
            ],
            actorUserId: $actor->id,
            subjectType: User::class,
            subjectId: (string) $user->id,
            isSecurityEvent: true,
        );

        $this->notifier->send(
            type: AuthNotificationTypes::MFA_RESET,
            recipient: $user,
            actor: $actor,
            subject: $user,
            data: [
                'body' => $actor->is($user)
                    ? 'Your MFA enrollment was reset.'
                    : "Your MFA enrollment was reset by {$actor->name}.",
            ],
        );

        return back()->with('status', 'MFA enrollment reset.');
    }
}
