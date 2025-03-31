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
        Schema::create('accounts', function (Blueprint $table) {
            // $table->id();
            // $table->unsignedBigInteger('user_id');
            // $table->string('name'); // Account name (Bank, Credit Card, Cash)
            // $table->enum('type', ['bank', 'credit_card', 'cash']);
            // $table->decimal('balance', 10, 2)->default(0);
            // $table->decimal('credit_limit', 10, 2)->nullable(); // Only for credit cards
            // $table->integer('billing_cycle_start')->nullable(); // Credit card billing start day
            // $table->integer('billing_cycle_end')->nullable(); // Credit card billing end day
            // $table->integer('due_date')->nullable(); // Credit card due date
            // $table->timestamps();

            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('name'); // Account name (Bank, Credit Card, Wallet)
            $table->enum('type', ['bank', 'credit_card', 'cash']);
            $table->decimal('balance', 15, 2)->default(0);
            $table->decimal('credit_limit', 15, 2)->nullable(); // For credit cards
            $table->integer('billing_cycle_start')->nullable();
            $table->integer('billing_cycle_end')->nullable();
            $table->integer('due_date')->nullable(); // Credit card due date
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
