<?php

namespace Database\Seeders;

use App\Models\SecurityRequirement;
use App\Models\SecurityRequirementGroup;
use App\Platform\Security\SecurityRequirementCatalog;
use Illuminate\Database\Seeder;

class SecurityRequirementSeeder extends Seeder
{
    public function run(): void
    {
        foreach (SecurityRequirementCatalog::groups() as $groupDefinition) {
            $group = SecurityRequirementGroup::query()->updateOrCreate(
                ['slug' => $groupDefinition['slug']],
                [
                    'title' => $groupDefinition['title'],
                    'summary' => $groupDefinition['summary'],
                    'asvs_family' => $groupDefinition['asvs_family'],
                    'risk_level' => $groupDefinition['risk_level'],
                    'sort_order' => $groupDefinition['sort_order'],
                ],
            );

            foreach ($groupDefinition['requirements'] as $requirementDefinition) {
                $requirement = SecurityRequirement::query()->firstOrNew([
                    'slug' => $requirementDefinition['slug'],
                ]);

                $catalogFields = [
                    'group_id' => $group->id,
                    'title' => $requirementDefinition['title'],
                    'summary' => $requirementDefinition['summary'],
                    'asvs_refs' => $requirementDefinition['asvs_refs'],
                    'canonical_docs' => $requirementDefinition['canonical_docs'],
                    'priority' => $requirementDefinition['priority'],
                ];

                $requirement->fill($catalogFields);

                if (! $requirement->exists) {
                    $requirement->fill([
                        'alignment_status' => $requirementDefinition['alignment_status'],
                        'work_status' => $requirementDefinition['work_status'],
                        'target_phase' => $requirementDefinition['target_phase'],
                        'evidence_links' => [],
                    ]);
                }

                $requirement->save();
            }
        }
    }
}
