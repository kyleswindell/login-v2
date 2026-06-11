<div class="mt-5 overflow-x-auto rounded-lg border" style="border-color: var(--ui-border-subtle-01); background: var(--ui-layer-01);">
    <table class="w-full min-w-[1120px] table-fixed divide-y" style="border-color: var(--ui-border-subtle-01);">
        <colgroup>
            <col class="w-[11rem]">
            <col class="w-[19rem]">
            <col class="w-[9rem]">
            <col class="w-[8rem]">
            <col class="w-[9rem]">
            <col>
            <col class="w-[18rem]">
        </colgroup>
        <thead style="background: var(--ui-layer-accent-01);">
            <tr class="text-left text-xs uppercase tracking-[0.18em]" style="color: var(--ui-text-helper);">
                <th class="px-4 py-3">Role</th>
                <th class="px-4 py-3">Class</th>
                <th class="px-4 py-3">Base size</th>
                <th class="px-4 py-3">Weight</th>
                <th class="px-4 py-3">Behavior</th>
                <th class="px-4 py-3">Rendered proof</th>
                <th class="px-4 py-3">Avoid</th>
            </tr>
        </thead>
        <tbody class="divide-y text-sm" style="border-color: var(--ui-border-subtle-01); color: var(--ui-text-secondary);">
            @foreach ($rows as $row)
                <tr data-type-set-row="{{ Str::slug($setName.' '.$row['role']) }}">
                    <td class="px-4 py-3 font-semibold" style="color: var(--ui-text-primary);">{{ $row['role'] }}</td>
                    <td class="px-4 py-3 font-mono text-xs" style="color: var(--ui-text-primary);">{{ $row['class'] }}</td>
                    <td class="px-4 py-3">{{ $row['size'] }}</td>
                    <td class="px-4 py-3">{{ $row['weight'] }}</td>
                    <td class="px-4 py-3">{{ $row['behavior'] }}</td>
                    <td class="px-4 py-3">
                        <div class="{{ Str::startsWith($row['class'], 'ui-type-productive') ? 'ui-type-set-productive' : 'ui-type-set-expressive' }}">
                            <p class="{{ $row['class'] }}">{{ $row['allowed'] }}</p>
                        </div>
                    </td>
                    <td class="px-4 py-3">{{ $row['avoid'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
