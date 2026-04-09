<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table): void {
            $table->id();
            $table->string('scope_type')->index();
            $table->string('scope_id')->nullable()->index();
            $table->string('module_key')->nullable()->index();
            $table->string('group_key')->index();
            $table->string('key');
            // One JSON value column lets Phase 1 cover simple flags and richer module
            // configuration without spawning a new settings table for each feature.
            $table->json('value_jsonb')->nullable();
            $table->string('data_type')->default('json')->index();
            $table->boolean('is_encrypted')->default(false)->index();
            $table->boolean('is_public')->default(false)->index();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['scope_type', 'scope_id', 'module_key', 'group_key', 'key'], 'settings_unique_scope_group_key');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
