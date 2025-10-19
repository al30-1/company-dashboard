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
    Schema::create('submodules', function (Blueprint $table) {
        $table->id();
        $table->foreignId('module_id')->constrained()->onDelete('cascade');
        $table->string('name');
        $table->string('code')->unique();
        $table->string('route')->nullable(); // optional frontend route (e.g., "/users/list")
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submodules');
    }
};
