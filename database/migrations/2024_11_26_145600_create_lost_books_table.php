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
            $table->foreignId('book_loan_id')->constrained()->onDelete('cascade');  // Reference to book_loans
            $table->foreignId('book_id')->constrained()->onDelete('cascade');  // Reference to books
            $table->string('user_id'); // Change foreign key to user_id (use personal_id as it references users)
            $table->foreign('user_id')->references('personal_id')->on('users')->onDelete('cascade'); // Corrected foreign key reference
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
