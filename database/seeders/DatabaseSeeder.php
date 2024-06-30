<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Use try-catch block to handle potential exceptions
        try {
            // Example of using firstOrCreate in your seeder
            $user = User::firstOrCreate(
                ['email' => 'test@example.com'],
                [
                    'name' => 'Test User',
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                    'remember_token' => Str::random(10),
                ]
            );
            $this->call([
                FloorSeeder::class,
                RoomCategorySeeder::class,
                RoomSeeder::class,

            ]);

            echo "User seeded successfully!\n";
        } catch (\Exception $e) {

            echo "Error seeding user: " . $e->getMessage() . "\n";
        }
    }
}
