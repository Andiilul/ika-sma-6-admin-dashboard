<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Filament umumnya butuh "name" untuk ditampilkan di header/user menu
            $table->string('name');

            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();

            $table->string('password');

            // 1=superadmin, 2=admin

            // Praktis untuk block akses tanpa hapus user

            $table->rememberToken();
            $table->timestamps();

            $table->unsignedTinyInteger('role')->default(2)->index()->comment('1=superadmin, 2=admin');
            $table->boolean('is_active')->default(true)->index();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
