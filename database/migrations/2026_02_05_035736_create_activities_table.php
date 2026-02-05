<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('title', 255);
            $table->string('short_description', 255);
            $table->longText('description');

            $table->date('date')->index();
            $table->string('location', 255)->nullable();

            $table->string('image_path', 2048)->nullable();

            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();

            $table->foreign('created_by', 'activities_created_by_fk')
                ->references('id')->on('users')
                ->nullOnDelete();

            $table->foreign('updated_by', 'activities_updated_by_fk')
                ->references('id')->on('users')
                ->nullOnDelete();

            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
