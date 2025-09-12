<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->enum('status', ['pending', 'in_progress', 'done', 'cancelled'])->default('pending');
            $table->decimal('estimated_cost', 8, 2)->nullable();
            $table->timestamps();
        });
    }
};