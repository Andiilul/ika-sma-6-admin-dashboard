<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('title');
            $table->string('short_description', 255);

            // RichEditor default output = HTML string
            $table->longText('description');

            // "YYYY-MM-DD"
            $table->date('date');

            $table->string('location')->nullable();

            // path/url thumbnail (nanti bisa FileUpload di Filament)
            $table->string('image')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index('date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
