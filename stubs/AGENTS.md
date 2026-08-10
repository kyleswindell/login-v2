# stubs AGENTS.md

## Purpose

Repository-owned source templates and scaffolding inputs.

This folder implements approved mechanical file shapes for framework overrides, repository archetypes, tests, and UI scaffolding. It does not own coding policy, architecture, feature behavior, verification policy, or generated output.

## Read Order

Before changing or applying a stub:

1. Read root `AGENTS.md`.
2. Read `stubs/README.md`.
3. Read [Code Template And Generator Standards](../docs/02-standards/coding/Code%20Template%20And%20Generator%20Standards.md).
4. Read [File Archetypes](../docs/02-standards/coding/File%20Archetypes.md) and [File Building Standards](../docs/02-standards/coding/File%20Building%20Standards.md) for the affected source type.
5. Read only the affected stub, generator, and representative generated output.
6. When test source is generated, read the [Test Implementation Standards Index](../docs/02-standards/coding/test-implementation/index.md) and the applicable child standard.
7. When proof requirements are affected, read the [Testing Standards Index](../docs/02-standards/testing/index.md).
8. When UI source is generated, read the applicable [UI Standards](../docs/02-standards/ui/index.md) and source-tree `AGENTS.md`.

Do not load every stub or generator for a narrow template change.

## Folder Roles

Use the existing stub branches according to their current purpose:

- `framework/` — reviewed or active framework-generator overrides;
- `archetypes/` — project-owned source archetype templates;
- `tests/` — project-owned test-source templates;
- `ui/` — project-owned UI-source templates.

`stubs/README.md` owns the current inventory and operator-facing usage notes.

Canonical policy remains in `docs/02-standards/`.

## Template Rules

- A stub is a mechanical input, not a canonical specification.
- Select the owning application or repository responsibility before selecting a stub.
- Select the file archetype before selecting a template.
- Preserve required strict types, headers, comments, namespaces, imports, placeholders, and public Contract shape defined by canonical standards.
- Keep placeholders explicit and deterministic.
- Generated output is scaffolding and still requires implementation, review, and verification.
- Do not introduce application behavior solely because a stub contains an example.
- Do not make a stub the only owner of a durable coding rule.
- Do not create a new stub when an existing generator or template already represents the required shape.
- Do not create broad generic templates for responsibilities that do not share one stable archetype.

## Framework Override Rules

Before changing or activating a Laravel root stub override, confirm:

- the installed framework generator that consumes it;
- the expected stub filename and lookup path;
- every supported placeholder;
- representative output from the actual generator;
- whether the project intentionally accepts maintenance responsibility for the override.

Do not infer framework stub behavior from filename similarity.

## Generated Output

For any changed template or generator, verify applicable:

- the intended generator consumes the template;
- all required placeholders resolve;
- no unresolved template markers remain;
- namespace and target path follow the owning architecture and naming standards;
- representative generated output matches the selected archetype;
- generated test source remains discoverable;
- generated UI source preserves required public Contracts and file headers;
- generated output does not introduce secrets, workstation paths, or environment-specific values.

Do not hand-edit generated output as a substitute for correcting a defective source template when the template is the actual owner of the defect.

## Verification

Use the issue or authorized work packet to determine required proof.

Template or generator work should normally include the smallest representative generation proof that demonstrates the affected output shape.

When generated test source is involved, follow the Test Implementation Standards. When the template changes an accepted verification baseline or observable proof behavior, follow the Testing Standards and stop if revision authority is not explicit.

Do not claim a generator, template, or generated artifact passed verification unless the declared command or procedure actually ran successfully.

## Avoid

- Do not place documentation templates in `stubs/`; documentation templates belong under `docs/09-reference/templates/`.
- Do not place canonical coding rules in this folder.
- Do not use current `app/Platform/` placement as target ownership.
- Do not introduce new target paths that conflict with `docs/03-architecture/repository-architecture.md`.
- Do not weaken generated tests or fixtures to make implementation pass.
- Do not modify unrelated templates while repairing one generator path.
- Do not activate or expand a framework override without confirming the installed framework behavior.
- Do not use `git add .` in a dirty working tree.

## Stop Conditions

Stop and report when:

- the owning responsibility or target path is unresolved;
- the applicable file archetype is unclear;
- the consuming generator cannot be identified;
- installed generator behavior differs from the documented assumption;
- a placeholder contract is unknown;
- the requested template would encode unresolved architecture, schema, security, UI, or verification behavior;
- representative output cannot be validated in the required environment;
- a protected test or fixture would require material revision without accepted authority;
- the change would require unrelated stub or generator cleanup.

## Related

- [Stub Templates README](README.md)
- [Code Template And Generator Standards](../docs/02-standards/coding/Code%20Template%20And%20Generator%20Standards.md)
- [File Archetypes](../docs/02-standards/coding/File%20Archetypes.md)
- [File Building Standards](../docs/02-standards/coding/File%20Building%20Standards.md)
- [PHP And Laravel Style Standards](../docs/02-standards/coding/PHP%20And%20Laravel%20Style%20Standards.md)
- [Commenting Standards](../docs/02-standards/coding/Commenting%20Standards.md)
- [Test Implementation Standards Index](../docs/02-standards/coding/test-implementation/index.md)
- [Testing Standards Index](../docs/02-standards/testing/index.md)
- [UI Standards Index](../docs/02-standards/ui/index.md)
