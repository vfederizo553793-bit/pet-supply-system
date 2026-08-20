<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('orders')) {
            return;
        }

        // Temporarily allow both paypal and gcash, migrate legacy mapped values, then keep gcash.
        DB::statement("ALTER TABLE orders MODIFY payment_method ENUM('credit_card','paypal','gcash','cash_on_delivery') NOT NULL");
        DB::table('orders')->where('payment_method', 'paypal')->update(['payment_method' => 'gcash']);
        DB::statement("ALTER TABLE orders MODIFY payment_method ENUM('credit_card','gcash','cash_on_delivery') NOT NULL");
    }

    public function down(): void
    {
        if (!Schema::hasTable('orders')) {
            return;
        }

        DB::statement("ALTER TABLE orders MODIFY payment_method ENUM('credit_card','paypal','gcash','cash_on_delivery') NOT NULL");
        DB::table('orders')->where('payment_method', 'gcash')->update(['payment_method' => 'paypal']);
        DB::statement("ALTER TABLE orders MODIFY payment_method ENUM('credit_card','paypal','cash_on_delivery') NOT NULL");
    }
};
