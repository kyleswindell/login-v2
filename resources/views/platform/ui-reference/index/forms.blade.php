        <section class="ui-card">
            <div>
                <p class="ui-kicker">Forms</p>
                <h2 class="ui-card-title mt-2">Input And Action Baseline</h2>
                <p class="ui-card-copy">Field spacing, helper text, disabled state readability, and explicit Save/Cancel action rows.</p>
            </div>

            <form class="mt-6 grid gap-5 lg:grid-cols-2" action="#" method="POST" onsubmit="event.preventDefault()">
                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Workspace Name <span class="text-rose-300">*</span></span>
                    <input type="text" value="Platform Operations Workspace" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 placeholder:text-slate-500 focus:border-slate-500 focus:outline-none" />
                    <p class="mt-2 text-xs text-slate-500">Shared name visible in platform navigation.</p>
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Owner Scope</span>
                    <select class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 focus:border-slate-500 focus:outline-none">
                        <option>Administrator</option>
                        <option>Base Operator</option>
                    </select>
                </label>

                <label class="block lg:col-span-2">
                    <span class="text-sm font-semibold text-slate-200">Description</span>
                    <textarea rows="3" class="mt-2 w-full rounded-md border border-slate-700 bg-slate-950 px-4 py-3 text-slate-100 placeholder:text-slate-500 focus:border-slate-500 focus:outline-none">Reusable UI baseline references for phase implementation reviews.</textarea>
                </label>

                <label class="block">
                    <span class="text-sm font-semibold text-slate-200">Locked Identifier</span>
                    <input type="text" value="ui-reference-v1" disabled class="mt-2 w-full rounded-md border border-slate-700 bg-slate-900/40 px-4 py-3 text-slate-400" />
                </label>

                <div class="flex flex-wrap items-end gap-3 lg:justify-end lg:col-span-2">
                    <button type="button" class="ui-action ui-action-ghost">Cancel</button>
                    <button type="submit" class="ui-action ui-action-primary">Save Workspace</button>
                </div>
            </form>
        </section>
