<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('alumnis', function (Blueprint $table) {
            // 1) add email (nullable biar aman untuk data lama)
            if (!Schema::hasColumn('alumnis', 'email')) {
                $table->string('email', 255)->nullable()->after('contact_number');
                $table->unique('email', 'alumnis_email_unique');
            }

            // 2) drop updated_by_new
            if (Schema::hasColumn('alumnis', 'updated_by_new')) {
                $table->dropColumn('updated_by_new');
            }
        });
    }

    public function down(): void
    {
        Schema::table('alumnis', function (Blueprint $table) {
            // rollback email
            if (Schema::hasColumn('alumnis', 'email')) {
                $table->dropUnique('alumnis_email_unique');
                $table->dropColumn('email');
            }

            // rollback updated_by_new (kalau kamu butuh balik)
            if (!Schema::hasColumn('alumnis', 'updated_by_new')) {
                $table->unsignedBigInteger('updated_by_new')->nullable()->after('updated_by');
            }
        });
    }
};
