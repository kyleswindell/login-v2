<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            // Phase 1 needs an explicit activation flag so platform access can be revoked
            // without deleting accounts or relying only on role removal.
            $table->boolean('is_active')->default(true)->after('password')->index();
            $table->timestamp('last_login_at')->nullable()->after('remember_token');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn(['is_active', 'last_login_at']);
        });
    }
};
