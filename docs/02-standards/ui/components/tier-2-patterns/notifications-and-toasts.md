# Tier 2 Notification And Toast Pattern Standards

## Purpose

Define the canonical Tier 2 patterns for toast notifications, persistent notifications, and inline validation and alert behavior.

This document ensures:

- clear separation between feedback types
- consistent UX across the application
- alignment with Tier 1 primitives and token system
- prevention of feature-level drift into reusable patterns

## Tier Boundary

### Tier 1

- primitives such as buttons, inputs, badges
- tokens such as color, spacing, typography
- accessibility foundations

### Tier 2

Reusable patterns:

- toast
- notification item
- notification list
- timestamp display
- avatar display
- action affordances

### Tier 3

Feature modules:

- notification center
- messaging
- project/event updates
- persistence and business logic

## Pattern Separation

### Toast Notifications

#### Purpose

Provide immediate, short-lived feedback.

#### Use Cases

- success messages
- quick informational alerts
- temporary warnings
- non-persistent system feedback

#### Rules

- not persisted
- not stored in notification system
- auto-dismiss with timeout
- may include optional action
- must be dismissible

#### Structure

- semantic icon/status
- single concise message
- optional action, maximum one
- dismiss control

#### Behavior

- animate in subtly
- animate out subtly
- stack vertically
- pause dismissal on hover if interactive

### Persistent Notifications

#### Purpose

Represent system events that require user awareness or later reference.

#### Use Cases

- new messages
- task assignments
- project/event updates
- mentions
- deadlines
- async failures

#### Rules

- persisted in notification system
- must support read/unread state
- may trigger a toast preview
- full interaction happens in notification UI

#### Content Structure

Actor plus action plus subject plus context.

Examples:

- Kevin Morris sent you a new message in Project Apex.
- Project Apex was updated.
- Task "Final QA Review" is due tomorrow.

#### Fields

- actor, user or system
- event type
- subject/entity
- optional context/location
- timestamp, absolute
- relative time
- read/unread state
- optional primary action

### Inline Validation And Alerts

#### Purpose

Provide local, contextual feedback within a page.

#### Use Cases

- form validation errors
- missing required fields
- invalid input
- same-page warnings

#### Rules

- tied to a specific field or section
- not persisted
- should not create notifications
- should not use toast if context is clear

#### Behavior

- scroll to error location
- focus input
- apply error styling
- replay error or danger animation only when motion remains appropriate

#### Toast Usage

Only use toast if:

- error is off-screen
- context is unclear
- system-level failure occurred

## Timestamp Standard

### Required

- relative time, primary
- absolute timestamp, secondary

### Display Rules

- show relative time inline
- show full timestamp on hover or detail

Examples:

- 2m ago
- 3h ago
- Yesterday
- hover/detail: 2026-04-15 14:32

## Avatar Standard

### Rules

- show profile image if available
- fallback to circular initial avatar
- must match header account avatar style

### Fallback Format

- circle
- background color
- uppercase initial

## Action Behavior

### Rules

- maximum one primary action per notification
- action labels must be short, such as View, Open, Reply, or Review

### Interaction

- clicking the notification body may act as primary action
- button is optional if behavior is obvious

## Toast vs Notification Policy

### Toast Only

- quick success feedback
- temporary info
- non-critical warnings
- local user actions

### Notification + Optional Toast

- messages
- assignments
- updates
- deadlines
- async failures

## Visual / Interaction Standards

### Toast

- subtle animation only
- no excessive motion
- must not block primary workflow

### Notification

- consistent layout
- clear hierarchy
- semantic color usage

### Inline Alerts

- minimal and contextual
- must not disrupt layout unnecessarily

## Non-Persisting Alert Format

For lightweight alerts:

- single-line message
- optional action
- dismiss option
- no metadata overload

Examples:

- File uploaded successfully.
- Project updated - View.

## Composition Rules

- Tier 2 patterns must use Tier 1 primitives only.
- Do not use direct styling outside the token system.
- Do not duplicate primitive behavior.
- Patterns must be reusable across features.

## Exclusions

The following are not part of Tier 2 patterns:

- feature-specific notification logic
- persistence rules
- domain-specific UI such as user management or messaging

## Validation

A Tier 2 notification system is valid only if:

- toast behavior is consistent and non-persistent
- notification structure follows canonical format
- inline validation does not create unnecessary notifications
- timestamp and avatar standards are applied
- no overlap or confusion exists between systems

## Future Integration

These patterns will be consumed by Tier 3 feature modules:

- Notification Center
- Messaging systems
- Project/event updates
- Task management

## Related

- [Boundary And Validation](boundary-and-validation.md)
- [Tier 2 Pattern Library Checklist](../Tier%202%20Pattern%20Library%20Checklist.md)
- [Tier 1 - Toast And Inline Alert Contract](../../contracts/Tier%201%20-%20Toast%20And%20Inline%20Alert%20Contract.md)
