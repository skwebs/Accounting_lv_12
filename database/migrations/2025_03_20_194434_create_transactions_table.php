<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            // $table->id();
            // $table->unsignedBigInteger('user_id');
            // $table->unsignedBigInteger('account_id'); // Bank, credit card, or cash
            // $table->enum('type', ['income', 'expense', 'transfer', 'credit_card_payment']);
            // $table->decimal('amount', 10, 2);
            // $table->string('category')->nullable(); // Food, Travel, etc.
            // $table->text('description')->nullable();
            // $table->unsignedBigInteger('related_account_id')->nullable(); // For transfers
            // $table->enum('loan_type', ['borrowed', 'lent', 'none'])->default('none');
            // $table->string('related_person')->nullable(); // Person for borrowed/lent money
            // $table->dateTime('transaction_date');
            // $table->timestamps();

            // $table->id();
            // $table->enum('type', ['income', 'expense', 'transfer', 'credit_card_payment', 'loan']);
            // $table->foreignId('account_id')->constrained('accounts')->onDelete('cascade');
            // $table->decimal('amount', 15, 2);
            // $table->enum('mode', ['UPI', 'Internet Banking', 'Cash', 'Debit Card', 'Credit Card']);
            // $table->string('upi_app')->nullable(); // e.g., Google Pay, PhonePe
            // $table->decimal('transaction_fee', 10, 2)->default(0);
            // $table->text('description')->nullable();
            // $table->timestamps();

            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('account_id'); // The main account affected
            $table->enum('type', ['income', 'expense', 'transfer', 'credit_card_payment', 'loan']);
            $table->decimal('amount', 15, 2);
            $table->string('category')->nullable(); // Groceries, Bills, etc.
            $table->text('description')->nullable();
            $table->unsignedBigInteger('related_account_id')->nullable(); // For transfers & CC payments
            $table->string('transaction_mode')->nullable(); // UPI, Cash, Debit Card
            $table->string('upi_app')->nullable(); // Google Pay, Paytm, etc.
            $table->decimal('transaction_fee', 15, 2)->default(0); // For UPI/Bank transfers
            $table->enum('loan_type', ['borrowed', 'lent', 'none'])->default('none');
            $table->string('related_person')->nullable(); // For loans
            $table->dateTime('transaction_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
