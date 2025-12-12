<?php

namespace Database\Seeders;

use App\Models\User;
use App\Http\Controllers\AdminHomepageSettingController;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Check if test user exists before creating to avoid duplicate error
        if (!User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            AdminUserSeeder::class,
        ]);

        // AdminHomepageSettingController::seedInitialSettings();
    }
}
