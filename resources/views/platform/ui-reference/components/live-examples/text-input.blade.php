@php
    $sections = [
        ['id' => 'variants', 'title' => 'Variants'],
        ['id' => 'styles', 'title' => 'Default and fluid styles'],
        ['id' => 'sizes', 'title' => 'Sizes'],
        ['id' => 'states', 'title' => 'States'],
        ['id' => 'textarea-features', 'title' => 'Text area features'],
        ['id' => 'password-features', 'title' => 'Password features'],
    ];
@endphp

<div class="space-y-6" data-component-live-layout="text-input-matrix" data-ui-reference-sample-type="text-input">
    <nav class="flex flex-wrap gap-2" aria-label="Text input example sections">
        @foreach ($sections as $section)
            <a class="ui-link text-sm" href="#text-input-{{ $section['id'] }}">{{ $section['title'] }}</a>
        @endforeach
    </nav>

    <section id="text-input-variants" class="ui-reference-layer-section" data-text-input-live-section="variants">
        <div class="ui-reference-section-heading">
            <h3>Variants</h3>
            <p>Text input owns single-line text, password input, and multi-line text area variants.</p>
        </div>
        <div class="mt-4 grid gap-4 lg:grid-cols-3">
            <article class="ui-reference-example-card">
                <h4 class="ui-reference-example-title">Text input</h4>
                <x-ui.text-input class="mt-4" name="workspace_name" label="Workspace name" value="North region" helper="Use a recognizable workspace name." />
            </article>
            <article class="ui-reference-example-card">
                <h4 class="ui-reference-example-title">Password input</h4>
                <x-ui.text-input class="mt-4" type="password" variant="password" name="account_password" label="Password" value="CorrectHorse2" helper="Use at least 12 characters." autocomplete="new-password" />
            </article>
            <article class="ui-reference-example-card">
                <h4 class="ui-reference-example-title">Text area</h4>
                <x-ui.text-input class="mt-4" type="textarea" variant="textarea" name="workspace_description" label="Description" value="Document why this workspace exists and who owns follow-up." helper="Use a short operational summary." />
            </article>
        </div>
    </section>

    <section id="text-input-styles" class="ui-reference-layer-section" data-text-input-live-section="styles">
        <div class="ui-reference-section-heading">
            <h3>Default and fluid styles</h3>
            <p>Default fields place labels and helper text outside the field. Fluid fields place the label inside the field and expose helper copy through tooltip semantics.</p>
        </div>
        <div class="mt-4 grid gap-4 lg:grid-cols-3">
            <article class="ui-reference-example-card">
                <h4 class="ui-reference-example-title">Default text input</h4>
                <x-ui.text-input class="mt-4" label="Email address" type="email" value="owner@example.com" helper="Use the workspace owner email." />
            </article>
            <article class="ui-reference-example-card">
                <h4 class="ui-reference-example-title">Fluid password input</h4>
                <x-ui.text-input class="mt-4" style="fluid" type="password" variant="password" label="Password" value="CorrectHorse2" helper="Use at least 12 characters." />
            </article>
            <article class="ui-reference-example-card">
                <h4 class="ui-reference-example-title">Fluid text area</h4>
                <x-ui.text-input class="mt-4" style="fluid" type="textarea" variant="textarea" label="Comments" value="Longer notes remain editable in a variable-height field." helper="Summarize the requested change." />
            </article>
        </div>
    </section>

    <section id="text-input-sizes" class="ui-reference-layer-section" data-text-input-live-section="sizes">
        <div class="ui-reference-section-heading">
            <h3>Sizes</h3>
            <p>Default text and password inputs support small, medium, and large heights. Fluid inputs use the 64px field height.</p>
        </div>
        <div class="mt-4 grid gap-4 lg:grid-cols-2">
            <article class="ui-reference-example-card">
                <h4 class="ui-reference-example-title">Text input sizes</h4>
                <div class="mt-4 grid gap-3">
                    <x-ui.text-input size="sm" label="Small" value="32px" />
                    <x-ui.text-input size="md" label="Medium" value="40px" />
                    <x-ui.text-input size="lg" label="Large" value="48px" />
                </div>
            </article>
            <article class="ui-reference-example-card">
                <h4 class="ui-reference-example-title">Password sizes</h4>
                <div class="mt-4 grid gap-3">
                    <x-ui.text-input size="sm" type="password" variant="password" label="Small password" value="secret" />
                    <x-ui.text-input size="md" type="password" variant="password" label="Medium password" value="secret" />
                    <x-ui.text-input size="lg" type="password" variant="password" label="Large password" value="secret" />
                </div>
            </article>
        </div>
    </section>

    <section id="text-input-states" class="ui-reference-layer-section" data-text-input-live-section="states">
        <div class="ui-reference-section-heading">
            <h3>States</h3>
            <p>Error and warning states replace helper text and include icon support. Disabled, read-only, focus, and skeleton states keep token-owned color roles.</p>
        </div>
        <div class="mt-4 grid gap-4 lg:grid-cols-3">
            <x-ui.text-input label="Enabled" value="Workspace alpha" helper="Enabled state accepts input." />
            <x-ui.text-input class="is-focus" label="Focus" value="Focused value" helper="Focus state persists after interaction." />
            <x-ui.text-input label="Error" value="" required error="Workspace name is required." />
            <x-ui.text-input label="Warning" value="Personal account" warning="This domain may need review." />
            <x-ui.text-input label="Disabled" value="Unavailable" disabled helper="Disabled state is not focusable." />
            <x-ui.text-input label="Read-only" value="Read-only value" readonly helper="Read-only remains readable." />
            <x-ui.text-input label="Skeleton" skeleton helper="Loading field." />
        </div>
    </section>

    <section id="text-input-textarea-features" class="ui-reference-layer-section" data-text-input-live-section="textarea-features">
        <div class="ui-reference-section-heading">
            <h3>Text area features</h3>
            <p>Text areas support variable height, vertical scrolling, resize handles, character counters, and word counters.</p>
        </div>
        <div class="mt-4 grid gap-4 lg:grid-cols-3">
            <x-ui.text-input type="textarea" variant="textarea" label="Resize handle" value="The resize handle changes height only." helper="Drag the lower-right handle to resize." />
            <x-ui.text-input type="textarea" variant="textarea" label="Character limit" value="Initial summary" maxlength="120" counter="characters" helper="Keep the summary short." />
            <x-ui.text-input type="textarea" variant="textarea" label="Word limit" value="Write clear operational notes." maxwords="20" counter="words" helper="Keep notes concise." />
        </div>
    </section>

    <section id="text-input-password-features" class="ui-reference-layer-section" data-text-input-live-section="password-features">
        <div class="ui-reference-section-heading">
            <h3>Password features</h3>
            <p>Password fields hide characters by default and provide a separate visibility toggle target.</p>
        </div>
        <div class="mt-4 grid gap-4 lg:grid-cols-3">
            <x-ui.text-input type="password" variant="password" label="Hidden password" value="CorrectHorse2" helper="Password is hidden by default." />
            <x-ui.text-input type="password" variant="password" label="Visible password" value="CorrectHorse2" password-visible helper="The toggle can reveal the value." />
            <x-ui.text-input type="password" variant="password" label="Password error" value="short" error="Password must be at least 12 characters." />
            <x-ui.text-input type="password" variant="password" label="Disabled password" value="CorrectHorse2" disabled />
            <x-ui.text-input type="password" variant="password" label="Read-only password" value="CorrectHorse2" readonly />
        </div>
    </section>
</div>
