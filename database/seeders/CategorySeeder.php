<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Men',
                'slug' => 'men',
                'description' => 'Latest fashion for men',
                'image' => 'https://picsum.photos/600/400?random=1',
                'is_active' => true,
            ],
            [
                'name' => 'Women',
                'slug' => 'women',
                'description' => 'Trending styles for women',
                'image' => 'https://picsum.photos/600/400?random=2',
                'is_active' => true,
            ],
            [
                'name' => 'Accessories',
                'slug' => 'accessories',
                'description' => 'Complete your look with accessories',
                'image' => 'https://picsum.photos/600/400?random=3',
                'is_active' => true,
            ],
            [
                'name' => 'Shoes',
                'slug' => 'shoes',
                'description' => 'Comfortable and stylish footwear',
                'image' => 'https://picsum.photos/600/400?random=4',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
