<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            return;
        }

        $products = [
            [
                'name' => 'Classic White T-Shirt',
                'slug' => 'classic-white-t-shirt',
                'category_slug' => 'men',
                'price' => 29.99,
                'description' => 'A comfortable and stylish classic white t-shirt for everyday wear.',
                'images' => ['https://picsum.photos/300/400?random=10', 'https://picsum.photos/300/400?random=11'],
            ],
            [
                'name' => 'Slim Fit Jeans',
                'slug' => 'slim-fit-jeans',
                'category_slug' => 'men',
                'price' => 59.99,
                'description' => 'Modern slim fit jeans made from high-quality denim.',
                'images' => ['https://picsum.photos/300/400?random=12', 'https://picsum.photos/300/400?random=13'],
            ],
            [
                'name' => 'Leather Jacket',
                'slug' => 'leather-jacket',
                'category_slug' => 'men',
                'price' => 199.99,
                'description' => 'Genuine leather jacket with a rugged look.',
                'images' => ['https://picsum.photos/300/400?random=14', 'https://picsum.photos/300/400?random=15'],
            ],
            [
                'name' => 'Summer Floral Dress',
                'slug' => 'summer-floral-dress',
                'category_slug' => 'women',
                'price' => 49.99,
                'description' => 'Beautiful floral dress perfect for summer outings.',
                'images' => ['https://picsum.photos/300/400?random=16', 'https://picsum.photos/300/400?random=17'],
            ],
            [
                'name' => 'Elegant Evening Gown',
                'slug' => 'elegant-evening-gown',
                'category_slug' => 'women',
                'price' => 129.99,
                'description' => 'Stunning evening gown for special occasions.',
                'images' => ['https://picsum.photos/300/400?random=18', 'https://picsum.photos/300/400?random=19'],
            ],
            [
                'name' => 'Running Sneakers',
                'slug' => 'running-sneakers',
                'category_slug' => 'shoes',
                'price' => 89.99,
                'description' => 'Lightweight and durable sneakers for running and sports.',
                'images' => ['https://picsum.photos/300/400?random=20', 'https://picsum.photos/300/400?random=21'],
            ],
            [
                'name' => 'Leather Handbag',
                'slug' => 'leather-handbag',
                'category_slug' => 'accessories',
                'price' => 79.99,
                'description' => 'Stylish leather handbag with plenty of space.',
                'images' => ['https://picsum.photos/300/400?random=22', 'https://picsum.photos/300/400?random=23'],
            ],
            [
                'name' => 'Classic Wristwatch',
                'slug' => 'classic-wristwatch',
                'category_slug' => 'accessories',
                'price' => 149.99,
                'description' => 'Timeless wristwatch design for both casual and formal wear.',
                'images' => ['https://picsum.photos/300/400?random=24', 'https://picsum.photos/300/400?random=25'],
            ],
        ];

        foreach ($products as $data) {
            $category = $categories->firstWhere('slug', $data['category_slug']);

            if (!$category) continue;

            Product::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'name' => $data['name'],
                    'category_id' => $category->id,
                    'description' => $data['description'],
                    'price' => $data['price'],
                    'sale_price' => null,
                    'sku' => strtoupper(substr($data['slug'], 0, 3) . rand(100, 999)),
                    'stock' => 100,
                    'images' => $data['images'],
                    'is_featured' => true,
                    'is_active' => true,
                ]
            );
        }
    }
}
