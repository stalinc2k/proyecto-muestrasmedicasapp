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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('code', 5);
            $table->string('name', 150);
            $table->string('email')->unique()->nullable();
            $table->string('phone', 10)->nullable();
            $table->boolean('active')->default(true);
            $table->foreignId('user_id')->constrained();
            
            $table->timestamps();
            $table->softDeletes('deleted_at')->nullable();
        });

        Schema::create('zones', function (Blueprint $table) {
            $table->id();
            $table->string('code', 4)->unique();
            $table->string('name', 50);
            $table->foreignId('user_id')->constrained();
            $table->foreignId('visitor_id')->constrained();
            $table->timestamps();
            $table->softDeletes('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zones');
    }
};
