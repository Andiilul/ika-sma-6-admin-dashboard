<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // OPTIONAL: normalize empty strings -> NULL (boleh skip kalau tabel masih kosong)
        DB::statement("UPDATE alumnis SET ethnicity = NULL WHERE ethnicity = ''");
        DB::statement("UPDATE alumnis SET domicile = NULL WHERE domicile = ''");
        DB::statement("UPDATE alumnis SET address = NULL WHERE address = ''");
        DB::statement("UPDATE alumnis SET profession = NULL WHERE profession = ''");
        DB::statement("UPDATE alumnis SET position = NULL WHERE position = ''");
        DB::statement("UPDATE alumnis SET hobby = NULL WHERE hobby = ''");
        DB::statement("UPDATE alumnis SET contact_number = NULL WHERE contact_number = ''");

        Schema::table('alumnis', function (Blueprint $table) {
            $table->enum('gender', ['male', 'female'])->nullable()->change();

            $table->string('ethnicity')->nullable()->change();
            $table->string('domicile')->nullable()->change();
            $table->text('address')->nullable()->change();

            $table->string('profession')->nullable()->change();
            $table->string('position')->nullable()->change();

            $table->string('hobby')->nullable()->change();
            $table->string('contact_number', 25)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('alumnis', function (Blueprint $table) {
            $table->enum('gender', ['male', 'female'])->nullable(false)->change();

            $table->string('ethnicity')->nullable(false)->change();
            $table->string('domicile')->nullable(false)->change();
            $table->text('address')->nullable(false)->change();

            $table->string('profession')->nullable(false)->change();
            $table->string('position')->nullable(false)->change();

            $table->string('hobby')->nullable(false)->change();
            $table->string('contact_number', 25)->nullable(false)->change();
        });
    }
};
