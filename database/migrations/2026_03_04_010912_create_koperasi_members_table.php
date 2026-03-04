<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('koperasi_members', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name', 255);
            $table->string('email', 255)->nullable()->unique();
            $table->string('phone', 32)->nullable();
            $table->string('image_path', 2048)->nullable();

            // audit (optional, tapi konsisten)
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();

            $table->foreign('created_by', 'koperasi_members_created_by_fk')
                ->references('id')->on('users')
                ->nullOnDelete();

            $table->foreign('updated_by', 'koperasi_members_updated_by_fk')
                ->references('id')->on('users')
                ->nullOnDelete();

            $table->timestamps();
            // $table->softDeletes(); // kalau mau
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('koperasi_members');
    }
};