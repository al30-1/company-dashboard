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
    Schema::create('user_submodule', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('submodule_id')->constrained()->onDelete('cascade');
        $table->timestamp('granted_at')->nullable();
        $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
        $table->timestamps(); // includes created_at, updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_submodule');
    }
};
