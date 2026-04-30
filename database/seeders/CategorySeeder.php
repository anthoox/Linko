<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->first();

        if (! $user) {
            return;
        }

        $categories = [
            ['name' => 'Productividad', 'icon' => 'heroicon-o-briefcase'],
            ['name' => 'Comunicacion', 'icon' => 'heroicon-o-chat-bubble-left-right'],
            ['name' => 'Desarrollo', 'icon' => 'heroicon-o-code-bracket'],
            ['name' => 'Diseno', 'icon' => 'heroicon-o-swatch'],
            ['name' => 'Almacenamiento', 'icon' => 'heroicon-o-cloud'],
        ];

        foreach ($categories as $category) {
            Category::query()->updateOrCreate(
                [
                    'user_id' => $user->id,
                    'name' => $category['name'],
                ],
                [
                    'icon' => $category['icon'],
                ]
            );
        }
    }
}
