<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use MoonShine\Laravel\Models\MoonshineUser;

class MoonshineUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Administrador
        MoonshineUser::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('12345678'),
                'moonshine_user_role_id' => 1,
            ]
        );

        // Profesor
        MoonshineUser::updateOrCreate(
            ['email' => 'profesor@example.com'],
            [
                'name' => 'Profesor',
                'password' => Hash::make('12345678'),
                'moonshine_user_role_id' => 2,
            ]
        );

        // Estudiante
        MoonshineUser::updateOrCreate(
            ['email' => 'estudiante@example.com'],
            [
                'name' => 'Estudiante',
                'password' => Hash::make('12345678'),
                'moonshine_user_role_id' => 3,
            ]
        );
    }
}
