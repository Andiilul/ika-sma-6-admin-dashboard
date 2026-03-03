<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();

            $table->string('title', 255);
            $table->string('slug', 255)->unique();

            $table->string('excerpt', 500)->nullable(); // atau Text kalau mau lebih panjang
            $table->longText('content');

            // status: draft|published|scheduled|archived
            $table->string('status', 20)->default('draft')->index();

            // kapan tampil publik
            $table->dateTime('published_at')->nullable()->index();

            // SEO
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_description', 500)->nullable();

            // OpenGraph image (path di storage/public)
            $table->string('og_image_path', 2048)->nullable();

            // author
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            // Optional: query common (published + time)
            $table->index(['status', 'published_at'], 'news_status_published_at_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};