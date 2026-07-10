<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('module_registry_entries', function (Blueprint $table): void {
            $table->id();
            $table->string('key')->unique();
            $table->string('name');
            $table->string('category')->index();
            $table->string('default_state')->index();
            $table->boolean('installed_by_default')->default(true)->index();
            $table->boolean('default_enabled')->default(true)->index();
            $table->boolean('disableable')->default(false)->index();
            $table->boolean('tenant_eligible')->default(false)->index();
            $table->json('dependencies_json')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('is_stale')->default(false)->index();
            $table->string('source_hash', 64)->nullable();
            $table->timestamp('synced_at')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('notification_registry_entries', function (Blueprint $table): void {
            $table->id();
            $table->string('key')->unique();
            $table->string('module_key')->index();
            $table->string('label');
            $table->text('description');
            $table->string('category')->index();
            $table->string('default_severity')->index();
            $table->string('audience')->index();
            $table->string('action_route')->nullable();
            $table->boolean('database_enabled')->default(true)->index();
            $table->boolean('email_eligible')->default(false)->index();
            $table->boolean('digest_eligible')->default(false)->index();
            $table->string('grouping_key')->nullable()->index();
            $table->unsignedInteger('dedupe_window_seconds')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('is_stale')->default(false)->index();
            $table->string('source_hash', 64)->nullable();
            $table->timestamp('synced_at')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('settings_registry_entries', function (Blueprint $table): void {
            $table->id();
            $table->string('key')->unique();
            $table->string('module_key')->index();
            $table->string('group_key')->index();
            $table->string('group_label');
            $table->string('label');
            $table->text('description')->nullable();
            $table->string('route_name')->index();
            $table->string('view_path');
            $table->string('icon');
            $table->string('access_mode')->nullable()->index();
            $table->string('access_value')->nullable()->index();
            $table->json('active_route_patterns_json')->nullable();
            $table->integer('group_sort_order')->default(0)->index();
            $table->integer('sort_order')->default(0)->index();
            $table->boolean('tenant_eligible')->default(false)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('is_stale')->default(false)->index();
            $table->string('source_hash', 64)->nullable();
            $table->timestamp('synced_at')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('setup_registry_entries', function (Blueprint $table): void {
            $table->id();
            $table->string('key')->unique();
            $table->string('module_key')->index();
            $table->string('label');
            $table->text('description')->nullable();
            $table->string('route_name')->index();
            $table->string('view_path');
            $table->string('icon');
            $table->string('access_mode')->nullable()->index();
            $table->string('access_value')->nullable()->index();
            $table->json('active_route_patterns_json')->nullable();
            $table->integer('sort_order')->default(0)->index();
            $table->boolean('tenant_eligible')->default(false)->index();
            $table->boolean('is_required')->default(false)->index();
            $table->boolean('is_blocking')->default(false)->index();
            $table->string('completion_key')->nullable()->index();
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('is_stale')->default(false)->index();
            $table->string('source_hash', 64)->nullable();
            $table->timestamp('synced_at')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('preference_registry_entries', function (Blueprint $table): void {
            $table->id();
            $table->string('key')->unique();
            $table->string('module_key')->index();
            $table->string('group_key')->index();
            $table->string('group_label');
            $table->string('label');
            $table->text('description')->nullable();
            $table->string('route_name')->index();
            $table->string('view_path');
            $table->string('icon');
            $table->string('access_mode')->nullable()->index();
            $table->string('access_value')->nullable()->index();
            $table->json('active_route_patterns_json')->nullable();
            $table->integer('group_sort_order')->default(0)->index();
            $table->integer('sort_order')->default(0)->index();
            $table->boolean('tenant_eligible')->default(false)->index();
            $table->string('storage_scope')->default('user')->index();
            $table->string('storage_table')->nullable()->index();
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('is_stale')->default(false)->index();
            $table->string('source_hash', 64)->nullable();
            $table->timestamp('synced_at')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('preference_registry_entries');
        Schema::dropIfExists('setup_registry_entries');
        Schema::dropIfExists('settings_registry_entries');
        Schema::dropIfExists('notification_registry_entries');
        Schema::dropIfExists('module_registry_entries');
    }
};
