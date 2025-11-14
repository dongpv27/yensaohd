<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class BestSellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cập nhật một số sản phẩm có sẵn thành best seller với sale
        $products = Product::take(10)->get();
        
        foreach ($products as $index => $product) {
            $hasSale = $index % 3 == 0; // Mỗi 3 sản phẩm thì có 1 sản phẩm sale
            
            $product->update([
                'is_best_seller' => true,
                'sold_count' => rand(10, 100),
                'original_price' => $hasSale ? $product->price : null,
                'sale_price' => $hasSale ? $product->price * 0.8 : null, // Giảm 20%
                'discount_percent' => $hasSale ? 20 : 0,
            ]);
        }
    }
}
