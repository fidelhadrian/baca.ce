<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_loan_id')->constrained()->onDelete('cascade');  // Referensi ke book_loans
            $table->enum('transaction_type', ['borrow', 'renewal', 'return', 'fine']);  // Jenis transaksi
            $table->decimal('amount', 8, 2)->default(0);  // Jumlah denda atau biaya lainnya
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
