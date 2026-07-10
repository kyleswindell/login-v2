{{-- ==========================================================================
    File: Modules/Dashboard/resources/views/partials/modal-action-pattern-tests.blade.php
    Purpose: Dashboard visual inspection surface for Modal Notification variants.

    Notes:
    - Temporary developer/admin inspection surface for the Modal Notification
      pattern.
    - Uses static examples only; no routes, controllers, persistence, or
      destructive mutations are performed.
    - Submit-state examples target a hidden inert iframe so native form submit
      loading behavior can be inspected without leaving the page.
    - Dialog open behavior is owned by resources/js/ui-controls/dialog.js.
    - Modal notification rendering is owned by x-patterns.notifications.modal.
    - RBAC-specific review tables are owned by Modules/Roles review partials.
    - Typed-confirmation behavior is owned by
      x-patterns.common-actions.destructive-actions.
    ========================================================================== --}}

@php
    /*
     *--------------------------------------------------------------------------
     * Standard role update review
     *--------------------------------------------------------------------------
     */

    $confirmationReview = [
        'subject' => [
            'type' => 'role',
            'id' => 2,
            'key' => 'manager',
            'label' => 'Manager',
            'assignedUsers' => 3,
            'isSystem' => false,
            'isElevated' => false,
        ],

        'permissionChangeRows' => [
            [
                'change' => 'enabled',
                'permission' => 'View users',
                'area' => 'Users',
                'accessLevel' => 'Standard',
                'result' => 'Added to role',
                'key' => 'users.view',
                'moduleKey' => 'users',
                'groupKey' => 'users',
                'description' => 'Allows access to user administration records.',
                'action' => 'view',
                'isElevated' => false,
                'isDestructive' => false,
                'isStale' => false,
            ],
            [
                'change' => 'enabled',
                'permission' => 'View roles',
                'area' => 'Roles',
                'accessLevel' => 'Standard',
                'result' => 'Added to role',
                'key' => 'roles.view',
                'moduleKey' => 'roles',
                'groupKey' => 'roles',
                'description' => 'Allows access to role inventory and role detail pages.',
                'action' => 'view',
                'isElevated' => false,
                'isDestructive' => false,
                'isStale' => false,
            ],
            [
                'change' => 'disabled',
                'permission' => 'View notifications',
                'area' => 'Notifications',
                'accessLevel' => 'Standard',
                'result' => 'Removed from role',
                'key' => 'notifications.view',
                'moduleKey' => 'notifications',
                'groupKey' => 'notifications',
                'description' => 'Removes access to notification panel data.',
                'action' => 'view',
                'isElevated' => false,
                'isDestructive' => false,
                'isStale' => false,
            ],
        ],

        'impactRows' => [
            [
                'impact' => 'Assigned users',
                'count' => 3,
                'effect' => 'Users receive updated access after save',
                'status' => 'Review',
            ],
        ],

        'blockerRows' => [],
    ];

    /*
     *--------------------------------------------------------------------------
     * Elevated role update review
     *--------------------------------------------------------------------------
     */

    $warningReview = [
        'subject' => [
            'type' => 'role',
            'id' => 1,
            'key' => 'admin',
            'label' => 'Admin',
            'assignedUsers' => 4,
            'isSystem' => true,
            'isElevated' => true,
        ],

        'permissionChangeRows' => [
            [
                'change' => 'enabled',
                'permission' => 'Manage users',
                'area' => 'Users',
                'accessLevel' => 'Elevated',
                'result' => 'Added to role',
                'key' => 'users.manage',
                'moduleKey' => 'users',
                'groupKey' => 'users',
                'description' => 'Create, update, deactivate, and assign allowed roles to users.',
                'action' => 'manage',
                'isElevated' => true,
                'isDestructive' => false,
                'isStale' => false,
            ],
            [
                'change' => 'enabled',
                'permission' => 'Manage roles',
                'area' => 'Roles',
                'accessLevel' => 'Elevated',
                'result' => 'Added to role',
                'key' => 'roles.manage',
                'moduleKey' => 'roles',
                'groupKey' => 'roles',
                'description' => 'Manage role permissions and role assignment rules.',
                'action' => 'manage',
                'isElevated' => true,
                'isDestructive' => false,
                'isStale' => false,
            ],
            [
                'change' => 'disabled',
                'permission' => 'View settings',
                'area' => 'Settings',
                'accessLevel' => 'Standard',
                'result' => 'Removed from role',
                'key' => 'settings.view',
                'moduleKey' => 'settings',
                'groupKey' => 'settings',
                'description' => 'Removes access to app-instance settings pages.',
                'action' => 'view',
                'isElevated' => false,
                'isDestructive' => false,
                'isStale' => false,
            ],
        ],

        'impactRows' => [
            [
                'impact' => 'Assigned users',
                'count' => 4,
                'effect' => 'Users receive updated administrative access after save',
                'status' => 'Review',
            ],
            [
                'impact' => 'Permissions added',
                'count' => 2,
                'effect' => 'Includes elevated administrative capabilities',
                'status' => 'Review',
            ],
            [
                'impact' => 'Permissions removed',
                'count' => 1,
                'effect' => 'Removed access takes effect after save',
                'status' => 'Review',
            ],
        ],

        'blockerRows' => [],
    ];

    /*
     *--------------------------------------------------------------------------
     * Destructive role delete review
     *--------------------------------------------------------------------------
     */

    $destructiveReview = [
        'subject' => [
            'type' => 'role',
            'id' => 2,
            'key' => 'manager',
            'label' => 'Manager',
            'assignedUsers' => 0,
            'isSystem' => false,
            'isElevated' => false,
        ],

        'permissionChangeRows' => [],

        'impactRows' => [
            [
                'impact' => 'Role record',
                'count' => 1,
                'effect' => 'The role record will be deleted',
                'status' => 'Review',
            ],
            [
                'impact' => 'Assigned users',
                'count' => 0,
                'effect' => 'No reassignment required for this visual example',
                'status' => 'OK',
            ],
        ],

        'blockerRows' => [],
    ];

    /*
     *--------------------------------------------------------------------------
     * Typed destructive role delete review
     *--------------------------------------------------------------------------
     */

    $typedReview = [
        'subject' => [
            'type' => 'role',
            'id' => 1,
            'key' => 'admin',
            'label' => 'Admin',
            'assignedUsers' => 4,
            'isSystem' => true,
            'isElevated' => true,
        ],

        'permissionChangeRows' => [],

        'impactRows' => [
            [
                'impact' => 'Typed confirmation',
                'count' => 1,
                'effect' => 'Destructive action requires the exact role name',
                'status' => 'Review',
            ],
            [
                'impact' => 'Administrative access',
                'count' => 4,
                'effect' => 'Users assigned to this role may be affected',
                'status' => 'Review',
            ],
        ],

        'blockerRows' => [],
    ];

    /*
     *--------------------------------------------------------------------------
     * Blocked role delete review
     *--------------------------------------------------------------------------
     */

    $blockedReview = [
        'subject' => [
            'type' => 'role',
            'id' => 1,
            'key' => 'super-admin',
            'label' => 'Super Admin',
            'assignedUsers' => 1,
            'isSystem' => true,
            'isElevated' => true,
        ],

        'permissionChangeRows' => [],

        'impactRows' => [],

        'blockerRows' => [
            [
                'blocker' => 'System role',
                'effect' => 'Super Admin is a protected system role',
                'status' => 'Blocked',
            ],
            [
                'blocker' => 'Admin-capable access',
                'effect' => 'At least one admin-capable role must remain',
                'status' => 'Blocked',
            ],
        ],
    ];

    /*
     *--------------------------------------------------------------------------
     * Busy role update review
     *--------------------------------------------------------------------------
     */

    $busyReview = [
        'subject' => [
            'type' => 'role',
            'id' => 2,
            'key' => 'manager',
            'label' => 'Manager',
            'assignedUsers' => 3,
            'isSystem' => false,
            'isElevated' => false,
        ],

        'permissionChangeRows' => [],

        'impactRows' => [
            [
                'impact' => 'Processing state',
                'count' => 1,
                'effect' => 'Generated actions are disabled to prevent duplicate submissions',
                'status' => 'Processing',
            ],
        ],

        'blockerRows' => [],
    ];
@endphp

<x-ui.v-stack :gap="5" data-dashboard-modal-notification-pattern-tests>
    {{-- ------------------------------------------------------------------
        Submit-state demo sink
        ------------------------------------------------------------------ --}}

    <iframe
        name="dashboard-modal-submit-sink"
        title="Dashboard modal submit sink"
        hidden
    ></iframe>

    <form
        id="dashboard-modal-action-confirmation-form"
        method="get"
        action="about:blank"
        target="dashboard-modal-submit-sink"
        data-ui-form-submit-state
        data-ui-form-submit-state-loading-text="Applying changes..."
        hidden
    ></form>

    <form
        id="dashboard-modal-action-warning-form"
        method="get"
        action="about:blank"
        target="dashboard-modal-submit-sink"
        data-ui-form-submit-state
        data-ui-form-submit-state-loading-text="Updating role..."
        hidden
    ></form>

    <form
        id="dashboard-modal-action-destructive-form"
        method="get"
        action="about:blank"
        target="dashboard-modal-submit-sink"
        data-ui-form-submit-state
        data-ui-form-submit-state-loading-text="Deleting role..."
        hidden
    ></form>

    <form
        id="dashboard-modal-action-typed-form"
        method="get"
        action="about:blank"
        target="dashboard-modal-submit-sink"
        data-ui-form-submit-state
        data-ui-form-submit-state-loading-text="Deleting protected role..."
        hidden
    ></form>

    {{-- ------------------------------------------------------------------
        Tile heading
        ------------------------------------------------------------------ --}}

    <x-ui.v-stack :gap="3">
        <h2 class="text-lg font-semibold ui-platform-text-strong">
            Modal notification pattern
        </h2>

        <p class="text-sm leading-6 ui-platform-text-muted">Open each modal to inspect confirmation, warning, destructive, typed-confirmation, blocked, and busy notification states.</p>
    </x-ui.v-stack>

    {{-- ------------------------------------------------------------------
        Trigger groups
        ------------------------------------------------------------------ --}}

    <x-ui.v-stack :gap="3" data-dashboard-modal-notification-pattern-triggers>
        <x-ui.v-stack :gap="2">
            <p class="text-xs font-semibold ui-platform-text-muted">Confirmation flows</p>

            <x-ui.h-stack :gap="2">
                <x-ui.button
                    href="#dashboard-modal-action-confirmation"
                    kind="secondary"
                    size="sm"
                    aria-controls="dashboard-modal-action-confirmation"
                    data-ui-dialog-trigger="dashboard-modal-action-confirmation"
                >
                    Confirmation
                </x-ui.button>

                <x-ui.button
                    href="#dashboard-modal-action-warning"
                    kind="secondary"
                    size="sm"
                    aria-controls="dashboard-modal-action-warning"
                    data-ui-dialog-trigger="dashboard-modal-action-warning"
                >
                    Warning edit
                </x-ui.button>

                <x-ui.button
                    href="#dashboard-modal-action-busy"
                    kind="tertiary"
                    size="sm"
                    aria-controls="dashboard-modal-action-busy"
                    data-ui-dialog-trigger="dashboard-modal-action-busy"
                >
                    Busy
                </x-ui.button>
            </x-ui.h-stack>
        </x-ui.v-stack>

        <x-ui.v-stack :gap="2">
            <p class="text-xs font-semibold ui-platform-text-muted">Restricted and destructive flows</p>

            <x-ui.h-stack :gap="2">
                <x-ui.button
                    href="#dashboard-modal-action-destructive"
                    kind="danger-tertiary"
                    size="sm"
                    aria-controls="dashboard-modal-action-destructive"
                    data-ui-dialog-trigger="dashboard-modal-action-destructive"
                >
                    Delete role
                </x-ui.button>

                <x-ui.button
                    href="#dashboard-modal-action-typed"
                    kind="danger-tertiary"
                    size="sm"
                    aria-controls="dashboard-modal-action-typed"
                    data-ui-dialog-trigger="dashboard-modal-action-typed"
                >
                    Typed delete
                </x-ui.button>

                <x-ui.button
                    href="#dashboard-modal-action-blocked"
                    kind="tertiary"
                    size="sm"
                    aria-controls="dashboard-modal-action-blocked"
                    data-ui-dialog-trigger="dashboard-modal-action-blocked"
                >
                    Blocked
                </x-ui.button>
            </x-ui.h-stack>
        </x-ui.v-stack>
    </x-ui.v-stack>

    {{-- ------------------------------------------------------------------
        Standard confirmation
        ------------------------------------------------------------------ --}}

    <x-patterns.notifications.modal
        id="dashboard-modal-action-confirmation"
        status="info"
        variant="confirmation"
        title="Apply role changes?"
        label="Confirmation"
        subject="Manager"
        confirm-label="Apply changes"
        cancel-label="Cancel"
        confirm-kind="primary"
        confirm-type="submit"
        form="dashboard-modal-action-confirmation-form"
        busy-label="Applying changes..."
        size="md"
        :has-scrolling-content="true"
    >
        <x-ui.v-stack :gap="5">
            <p>Review the permission changes for Manager before applying them to assigned users.</p>

            @include ("roles::partials.review.permission-change-table",
                [
                    "review" => $confirmationReview
                ])

            @include ("roles::partials.review.impact-summary",
                [
                    "review" => $confirmationReview
                ])
        </x-ui.v-stack>
    </x-patterns.notifications.modal>

    {{-- ------------------------------------------------------------------
        Warning confirmation for security-impacting edits
        ------------------------------------------------------------------ --}}

    <x-patterns.notifications.modal
        id="dashboard-modal-action-warning"
        status="warning"
        variant="confirmation"
        title="Update elevated role permissions?"
        label="Security change"
        subject="Admin"
        confirm-label="Update role"
        cancel-label="Cancel"
        confirm-kind="primary"
        confirm-type="submit"
        form="dashboard-modal-action-warning-form"
        busy-label="Updating role..."
        size="md"
        :alert="true"
        :close-on-backdrop="false"
        :has-scrolling-content="true"
    >
        <x-ui.v-stack :gap="5">
            <p>Review elevated permission changes for Admin before updating assigned users.</p>

            @include ("roles::partials.review.permission-change-table",
                [
                    "review" => $warningReview
                ])

            @include ("roles::partials.review.impact-summary",
                [
                    "review" => $warningReview
                ])
        </x-ui.v-stack>
    </x-patterns.notifications.modal>

    {{-- ------------------------------------------------------------------
        Destructive confirmation
        ------------------------------------------------------------------ --}}

    <x-patterns.notifications.modal
        id="dashboard-modal-action-destructive"
        status="error"
        variant="destructive"
        title="Delete role?"
        label="Destructive action"
        subject="Manager"
        confirm-label="Delete role"
        cancel-label="Cancel"
        confirm-type="submit"
        form="dashboard-modal-action-destructive-form"
        busy-label="Deleting role..."
        size="md"
        danger
        alert
        :close-on-backdrop="false"
        :has-scrolling-content="true"
    >
        <x-ui.v-stack :gap="5">
            <p>Review the consequences before deleting Manager. This action should only be available for safe custom-role delete flows.</p>

            @include ("roles::partials.review.impact-summary",
                [
                    "review" => $destructiveReview
                ])
        </x-ui.v-stack>
    </x-patterns.notifications.modal>

    {{-- ------------------------------------------------------------------
        Critical typed-confirmation flow
        ------------------------------------------------------------------ --}}

    <x-patterns.notifications.modal
        id="dashboard-modal-action-typed"
        status="error"
        variant="destructive"
        title="Permanently delete protected role?"
        label="Critical destructive action"
        subject="Admin"
        size="md"
        danger
        alert
        :close-on-backdrop="false"
        :has-scrolling-content="true"
    >
        <x-ui.v-stack :gap="5">
            <p>Review the risk summary before entering the role name to enable the destructive action.</p>

            @include ("roles::partials.review.impact-summary",
                [
                    "review" => $typedReview
                ])
        </x-ui.v-stack>

        <x-slot:footer>
            <x-patterns.common-actions.destructive-actions
                mode="confirmation"
                placement="dialog-footer"
                severity="critical"
                subject="Admin"
                action-label="Delete role"
                cancel-label="Cancel"
                require-typed-confirmation
                typed-confirmation-value="Admin"
                :actions="[['visible' => false]]"
            >
                <x-ui.button
                    type="button"
                    kind="secondary"
                    size="md"
                    data-ui-dialog-secondary="true"
                    data-ui-dialog-close="true"
                    data-ui-form-action="true"
                    data-ui-form-action-role="cancel"
                    data-ui-form-action-kind="secondary"
                    data-ui-form-action-type="button"
                    data-ui-form-action-allow-during-busy="false"
                    data-ui-destructive-action
                    data-ui-destructive-action-role="cancel"
                    data-ui-destructive-action-kind="secondary"
                    data-ui-destructive-action-type="button"
                    data-ui-destructive-action-index="0"
                    data-ui-destructive-action-destructive="false"
                    data-ui-destructive-action-disabled="false"
                    data-ui-destructive-action-loading="false"
                    data-ui-destructive-action-locked="false"
                    data-ui-destructive-action-requires-typed-confirmation="false"
                >
                    Cancel
                </x-ui.button>

                <x-ui.button
                    type="submit"
                    kind="danger"
                    size="md"
                    form="dashboard-modal-action-typed-form"
                    disabled
                    data-ui-dialog-primary="true"
                    data-ui-form-action="true"
                    data-ui-form-action-role="delete"
                    data-ui-form-action-kind="danger"
                    data-ui-form-action-type="submit"
                    data-ui-form-action-allow-during-busy="false"
                    data-ui-destructive-action
                    data-ui-destructive-action-role="delete"
                    data-ui-destructive-action-kind="danger"
                    data-ui-destructive-action-type="submit"
                    data-ui-destructive-action-index="1"
                    data-ui-destructive-action-destructive="true"
                    data-ui-destructive-action-disabled="true"
                    data-ui-destructive-action-loading="false"
                    data-ui-destructive-action-locked="false"
                    data-ui-destructive-action-requires-typed-confirmation="true"
                >
                    Delete role
                </x-ui.button>
            </x-patterns.common-actions.destructive-actions>
        </x-slot:footer>
    </x-patterns.notifications.modal>

    {{-- ------------------------------------------------------------------
        Blocked action
        ------------------------------------------------------------------ --}}

    <x-patterns.notifications.modal
        id="dashboard-modal-action-blocked"
        status="error"
        variant="blocked"
        title="Role cannot be deleted"
        label="Action unavailable"
        subject="Super Admin"
        close-label="Close"
        size="md"
        alert
        :close-on-backdrop="false"
        :has-scrolling-content="true"
    >
        <x-ui.v-stack :gap="5">
            <p>This role is protected. Review the blockers below before choosing another action.</p>

            @include ("roles::partials.review.blocker-summary",
                [
                    "review" => $blockedReview
                ])
        </x-ui.v-stack>
    </x-patterns.notifications.modal>

    {{-- ------------------------------------------------------------------
        Busy / processing state
        ------------------------------------------------------------------ --}}

    <x-patterns.notifications.modal
        id="dashboard-modal-action-busy"
        status="info"
        variant="confirmation"
        title="Updating role"
        label="Processing"
        subject="Manager"
        confirm-label="Update role"
        busy-label="Updating..."
        cancel-label="Cancel"
        size="md"
        busy
        :has-scrolling-content="true"
    >
        <x-ui.v-stack :gap="5">
            <p>This example shows the generated busy state for modal notification decisions.</p>

            @include ("roles::partials.review.impact-summary",
                [
                    "review" => $busyReview
                ])
        </x-ui.v-stack>
    </x-patterns.notifications.modal>
</x-ui.v-stack>
