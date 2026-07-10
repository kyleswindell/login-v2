<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permission_registry_entries', function (Blueprint $table): void {
            $table->id();
            $table->string('key')->unique();
            $table->foreignId('permission_id')->nullable()->constrained('permissions')->nullOnDelete();
            $table->string('module_key')->index();
            $table->string('group_key')->index();
            $table->string('group_label');
            $table->string('action')->index();
            $table->string('label');
            $table->text('description');
            $table->boolean('is_elevated')->default(false)->index();
            $table->boolean('is_destructive')->default(false)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('is_stale')->default(false)->index();
            $table->string('source_hash', 64)->nullable();
            $table->timestamp('synced_at')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('role_metadata', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('role_id')->unique()->constrained('roles')->cascadeOnDelete();
            $table->string('label');
            $table->text('description')->nullable();
            $table->boolean('is_system')->default(false)->index();
            $table->boolean('is_default')->default(false)->index();
            $table->boolean('is_protected')->default(false)->index();
            $table->boolean('is_deletable')->default(true)->index();
            $table->boolean('is_assignable')->default(true)->index();
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_metadata');
        Schema::dropIfExists('permission_registry_entries');
    }
};
