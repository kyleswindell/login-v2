<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('security_requirement_groups', function (Blueprint $table): void {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('summary')->nullable();
            $table->string('asvs_family')->nullable()->index();
            $table->string('risk_level')->default('level_2')->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();
        });

        Schema::create('security_requirements', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('group_id')->constrained('security_requirement_groups')->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('summary')->nullable();
            $table->json('asvs_refs')->nullable();
            $table->json('canonical_docs')->nullable();
            $table->string('alignment_status')->default('lacking')->index();
            $table->string('work_status')->default('not_started')->index();
            $table->string('priority')->default('medium')->index();
            $table->foreignId('owner_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('target_phase')->nullable()->index();
            $table->json('evidence_links')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('last_reviewed_at')->nullable();
            $table->foreignId('last_reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['group_id', 'alignment_status']);
            $table->index(['group_id', 'work_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('security_requirements');
        Schema::dropIfExists('security_requirement_groups');
    }
};
