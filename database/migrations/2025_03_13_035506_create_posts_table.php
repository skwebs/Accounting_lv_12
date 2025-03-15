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
        Schema::create('posts', function (Blueprint $table) {
            // $table->id();
            // $table->unsignedBigInteger('user_id');
            // $table->unsignedBigInteger('category_id')->nullable();
            // $table->string('title');
            // $table->text('content');
            // $table->unsignedInteger('views')->default(0);
            // $table->unsignedInteger('likes')->default(0);
            // $table->unsignedInteger('comments')->default(0);
            // $table->unsignedInteger('shares')->default(0);
            // $table->unsignedInteger('dislikes')->default(0);
            // $table->unsignedInteger('status')->default(0); // 0: Draft, 1: Published, 2: Trash
            // $table->unsignedInteger('order')->default(0);
            // $table->unsignedInteger('created_by')->nullable();
            // $table->unsignedInteger('updated_by')->nullable();
            // $table->softDeletes();

            // $table->timestamps();

            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Reference to users table
            $table->string('title');
            $table->text('content');
            $table->boolean('status')->default(0); // 0: Draft, 1: Published
            $table->softDeletes(); // Soft delete support
            $table->timestamps(); // Created_at & Updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
