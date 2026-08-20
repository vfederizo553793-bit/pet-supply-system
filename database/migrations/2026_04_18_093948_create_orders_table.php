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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('recipient_name');
            $table->text('delivery_address');
            $table->string('contact_number');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('shipping_fee',8, 2)->default(0);
            $table->enum('payment_method', ['credit_card', 'paypal', 'cash_on_delivery']);
            $table->enum('status', ['pending', 'processing', 'shipped', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
