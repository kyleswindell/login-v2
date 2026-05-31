# Tier 1 - Layout And Scaffolding Contract

This document defines the canonical scope and intent for Tier 1 - Layout And Scaffolding Contract.

## Component Contract

### 1. Component Identity

- Component name: Container, Grid, Stack / Flex, Section / Panel
- Taxonomy path (L1/L2): Baseline layout and scaffolding primitives
- Owner: Platform UI baseline owner

### 2. Intent And Theory

- Primary use case: Provide the structural layout primitives that Tier 1 shells and components compose into stable surfaces.
- When to use: Page framing, responsive layout, vertical rhythm, panel grouping, and baseline section structure.
- When not to use: Higher-order content patterns such as cards, dashboards, empty states, or other Tier 2 assemblies.
- Interaction intent summary: layout primitives create consistent spacing, containment, and hierarchy without embedding feature behavior.

### 2A. Tier Boundary Decision

- Current implementation form:
  - Container, Grid, Stack / Flex: `Class/markup contract`
  - Section / Panel: `Class/markup contract`, but boundary requires revalidation
- Intended long-term direction:
  - Container, Grid, Stack / Flex: `keep as class/markup contract`
  - Section / Panel: `revalidate Tier 1 boundary`
- Tier 1 section/panel baseline includes:
  - passive grouped region
  - optional visible frame
  - baseline title/copy spacing
- Tier 1 section/panel baseline does not automatically include:
  - card semantics
  - header action rows
  - status/chip bundles
  - richer content-section choreography
- When those richer content assemblies are needed, they should be treated as Tier 2 patterns rather than silently expanding the Tier 1 scaffold.

### 3. States

- Container: passive only.
- Grid: passive only.
- Stack / Flex: passive only.
- Section / Panel: default only; interactive states belong to nested controls, not the scaffold.

### 4. Key Rules

- Container defines readable max-width and horizontal page padding.
- Grid defines responsive column behavior and gap usage through canonical spacing tokens.
- Stack / Flex defines direction, alignment, and spacing primitives without becoming a pattern library substitute.
- Section / Panel provides baseline structural grouping only and must not absorb Tier 2 card semantics unless a later contract explicitly says so.

### 5. Token Usage

- use canonical spacing scale
- use canonical typography hierarchy for section titles and supporting text
- use canonical radius, border, and elevation rules only where the scaffold requires visible framing

### 6. Variant Rules

- Container: not variant-bearing
- Grid: not variant-bearing
- Stack / Flex: not variant-bearing
- Section / Panel: `base` only

## Anti-Patterns

- Anti-pattern 1: using Tier 1 section/panel as a catch-all substitute for every card-like content pattern
- Anti-pattern 2: embedding Tier 2 action/status choreography into a primitive scaffold without a higher-tier contract
- Anti-pattern 3: treating visible framing alone as proof that a reusable content pattern belongs in Tier 1

## Related

- [UI UX Foundations And Theming Standards](../UI%20UX%20Foundations%20And%20Theming%20Standards.md)
- [UI UX Component Taxonomy And Coverage Matrix](../components/UI%20UX%20Component%20Taxonomy%20And%20Coverage%20Matrix.md)
- [UI Design System Standards](../UI%20Design%20System%20Standards.md)
