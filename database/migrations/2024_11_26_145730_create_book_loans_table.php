<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('book_loans', function (Blueprint $table) {
            $table->id();
            $table->string('isbn');
            $table->foreign('isbn')->references('isbn')->on('books');
            $table->string('personal_id');
            $table->foreign('personal_id')->references('personal_id')->on('users');
            $table->date('loan_date');
            $table->date('due_date');
            $table->date('return_date')->nullable();
            $table->date('renewed_at')->nullable();
            $table->integer('fine')->default(0);
            $table->enum('loan_status', ['active', 'overdue', 'returned'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_loans');
    }
};
