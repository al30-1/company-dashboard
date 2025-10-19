<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        // Drop the 'email' column if you want to make it optional (as per spec: "email(optional unique string)")
        // But Laravel's default users table has email as required, so we'll just make it nullable and keep unique
        $table->string('email')->nullable()->change();

        // Add new fields
        $table->string('username')->unique()->after('name');
        $table->string('full_name')->after('username');
        $table->foreignId('company_id')->constrained()->after('full_name');
        $table->boolean('is_active')->default(true)->after('company_id');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['username', 'full_name', 'company_id', 'is_active']);
        $table->string('email')->nullable(false)->change(); // restore if needed
    });
}
};
