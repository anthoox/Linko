<?php

namespace Database\Seeders;

use App\Models\AppService;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class AppServiceSeeder extends Seeder
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

        $servicesByCategory = [
            'Productividad' => [
                [
                    'name' => 'Notion',
                    'url' => 'https://www.notion.so',
                    'description' => 'Espacio de trabajo para notas, documentos y gestion de tareas.',
                    'is_favorite' => true,
                ],
                [
                    'name' => 'Trello',
                    'url' => 'https://trello.com',
                    'description' => 'Tableros kanban para organizar proyectos y equipos.',
                    'is_favorite' => false,
                ],
            ],
            'Comunicacion' => [
                [
                    'name' => 'Slack',
                    'url' => 'https://slack.com',
                    'description' => 'Mensajeria de equipo con canales e integraciones.',
                    'is_favorite' => true,
                ],
                [
                    'name' => 'Discord',
                    'url' => 'https://discord.com',
                    'description' => 'Comunicacion por chat, voz y video para comunidades y equipos.',
                    'is_favorite' => false,
                ],
            ],
            'Desarrollo' => [
                [
                    'name' => 'GitHub',
                    'url' => 'https://github.com',
                    'description' => 'Plataforma para alojar repositorios y colaborar en codigo.',
                    'is_favorite' => true,
                ],
                [
                    'name' => 'Postman',
                    'url' => 'https://www.postman.com',
                    'description' => 'Herramienta para probar APIs y automatizar colecciones.',
                    'is_favorite' => false,
                ],
            ],
            'Diseno' => [
                [
                    'name' => 'Figma',
                    'url' => 'https://www.figma.com',
                    'description' => 'Diseno colaborativo de interfaces y prototipos.',
                    'is_favorite' => true,
                ],
                [
                    'name' => 'Canva',
                    'url' => 'https://www.canva.com',
                    'description' => 'Creacion rapida de piezas visuales y presentaciones.',
                    'is_favorite' => false,
                ],
            ],
            'Almacenamiento' => [
                [
                    'name' => 'Google Drive',
                    'url' => 'https://drive.google.com',
                    'description' => 'Almacenamiento en la nube y colaboracion en documentos.',
                    'is_favorite' => false,
                ],
                [
                    'name' => 'Dropbox',
                    'url' => 'https://www.dropbox.com',
                    'description' => 'Sincronizacion y almacenamiento compartido de archivos.',
                    'is_favorite' => false,
                ],
            ],
        ];

        foreach ($servicesByCategory as $categoryName => $services) {
            $category = Category::query()
                ->where('user_id', $user->id)
                ->where('name', $categoryName)
                ->first();

            if (! $category) {
                continue;
            }

            foreach ($services as $service) {
                AppService::query()->updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'category_id' => $category->id,
                        'name' => $service['name'],
                    ],
                    [
                        'url' => $service['url'],
                        'description' => $service['description'],
                        'image_path' => null,
                        'is_favorite' => $service['is_favorite'],
                    ]
                );
            }
        }
    }
}
