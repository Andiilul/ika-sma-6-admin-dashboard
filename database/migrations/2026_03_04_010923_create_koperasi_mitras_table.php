<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('koperasi_mitras', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->string('logo_path', 2048)->nullable();

            $table->string('slug', 255)->unique();       // wajib unik buat url/identitas
            $table->string('website_url', 2048)->nullable();

            // audit (optional)
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();

            $table->foreign('created_by', 'koperasi_mitras_created_by_fk')
                ->references('id')->on('users')
                ->nullOnDelete();

            $table->foreign('updated_by', 'koperasi_mitras_updated_by_fk')
                ->references('id')->on('users')
                ->nullOnDelete();

            $table->timestamps();
            // $table->softDeletes(); // kalau mau
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('koperasi_mitras');
    }
};