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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('code', 14)->unique();
            $table->string('name', 100);
            $table->string('address', 150)->nullable();
            $table->string('phone', 10)->nullable();
            $table->string('ruc', 13);
            $table->enum('type',['major','supplier'])->default('supplier');
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
