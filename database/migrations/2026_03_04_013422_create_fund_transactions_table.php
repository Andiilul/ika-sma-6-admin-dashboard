<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fund_transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name', 255);
            $table->text('description')->nullable();

            $table->decimal('amount', 14, 2);

            $table->enum('type', ['income', 'expense']); // masuk / keluar
            $table->date('transaction_date');

            $table->string('category', 120)->nullable();

            // biar bisa tandai "hasil usaha koperasi"
            $table->enum('source', [
                'koperasi_business', // hasil usaha koperasi
                'member_dues',       // iuran anggota
                'donation',          // donasi
                'external_support',  // bantuan eksternal
                'other',
            ])->default('other');

            $table->enum('payment_method', [
                'cash',
                'transfer',
                'qris',
                'ewallet',
                'other',
            ])->default('other');

            $table->string('proof_image_path', 2048)->nullable();

            // audit
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();

            $table->foreign('created_by', 'fund_tx_created_by_fk')
                ->references('id')->on('users')
                ->nullOnDelete();

            $table->foreign('updated_by', 'fund_tx_updated_by_fk')
                ->references('id')->on('users')
                ->nullOnDelete();

            $table->timestamps();
            // $table->softDeletes();

            $table->index(['type', 'transaction_date'], 'fund_tx_type_date_idx');
            $table->index(['category'], 'fund_tx_category_idx');
            $table->index(['source'], 'fund_tx_source_idx');
            $table->index(['payment_method'], 'fund_tx_paymethod_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fund_transactions');
    }
};