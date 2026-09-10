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
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('order_number')->unique();
            $table->string('customer_name')->nullable();
            $table->string('table_number')->nullable();
            $table->decimal('total_price', 12, 2)->default(0);
            $table->string('status')->default('pending'); // pending, diproses, selesai, dibatalkan
            $table->string('payment_method')->default('tunai');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
