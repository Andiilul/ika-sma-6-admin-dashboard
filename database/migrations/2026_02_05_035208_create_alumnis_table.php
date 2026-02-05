<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('alumnis', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name', 255);

            // NISN: simpan sebagai string (aman dari leading zero), unik
            $table->string('nisn', 32)->unique();

            // sesuai interface kamu: male/female
            $table->enum('gender', ['male', 'female']);

            $table->unsignedSmallInteger('graduation_year')->index();

            $table->string('ethnicity', 255)->nullable();
            $table->string('domicile', 255)->nullable();
            $table->text('address')->nullable();

            $table->string('profession', 255)->nullable();
            $table->string('position', 255)->nullable();

            // sesuai interface kamu: makassar / non-makassar
            $table->enum('location', ['makassar', 'non-makassar'])->index();

            $table->string('hobby', 255)->nullable();
            $table->string('contact_number', 32)->nullable();

            // path file di storage/public (contoh: alumnis/xxx.webp)
            $table->string('image_path', 2048)->nullable();

            // user yang terakhir edit
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumnis');
    }
};
