<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumnis', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name');
            $table->string('nisn', 20)->unique();

            $table->enum('gender', ['male', 'female']);
            $table->unsignedSmallInteger('graduation_year')->index();

            $table->string('ethnicity');
            $table->string('domicile');
            $table->text('address');

            $table->string('profession');
            $table->string('position');

            $table->enum('location', ['makassar', 'non-makassar'])->index();

            $table->string('hobby');
            $table->string('contact_number', 25);

            $table->string('image_url'); // path/url image

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alumnis');
    }
};
