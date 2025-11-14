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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('original_price', 10, 2)->nullable()->after('price');
            $table->decimal('sale_price', 10, 2)->nullable()->after('original_price');
            $table->integer('discount_percent')->default(0)->after('sale_price');
            $table->boolean('is_best_seller')->default(false)->after('discount_percent');
            $table->integer('sold_count')->default(0)->after('is_best_seller');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['original_price', 'sale_price', 'discount_percent', 'is_best_seller', 'sold_count']);
        });
    }
};
