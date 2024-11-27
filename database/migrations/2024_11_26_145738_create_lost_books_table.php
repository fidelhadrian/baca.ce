<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lost_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_loan_id')->constrained()->onDelete('cascade');  // Referensi ke book_loans
            $table->foreignId('book_id')->constrained()->onDelete('cascade');  // Referensi ke books
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // Referensi ke users (siapa yang melaporkan)
            $table->date('date_reported');
            $table->enum('replacement_status', ['pending', 'replaced'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lost_books');
    }
};
