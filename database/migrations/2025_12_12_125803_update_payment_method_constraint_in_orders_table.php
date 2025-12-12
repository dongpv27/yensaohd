<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the old constraint first
        DB::statement("ALTER TABLE orders DROP CONSTRAINT IF EXISTS orders_payment_method_check");
        
        // Update existing 'online' records back to 'vnpay' if any
        DB::table('orders')->where('payment_method', 'online')->update(['payment_method' => 'vnpay']);
        
        // Add new constraint with all payment methods
        DB::statement("ALTER TABLE orders ADD CONSTRAINT orders_payment_method_check CHECK (payment_method IN ('cod', 'bank', 'vnpay', 'momo', 'zalopay'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the constraint first
        DB::statement("ALTER TABLE orders DROP CONSTRAINT IF EXISTS orders_payment_method_check");
        
        // Update any new payment methods back to vnpay
        DB::table('orders')->whereIn('payment_method', ['momo', 'zalopay'])->update(['payment_method' => 'vnpay']);
        
        // Add old constraint
        DB::statement("ALTER TABLE orders ADD CONSTRAINT orders_payment_method_check CHECK (payment_method IN ('cod', 'bank', 'vnpay'))");
    }
};
