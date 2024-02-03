<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarUserAssocSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('cars_users_assoc')->insert([
            [
                'id_car' => 1,
                'id_user' => 3
            ],
            [
                'id_car' => 2,
                'id_user' => 1
            ],
            [
                'id_car' => 3,
                'id_user' => 3
            ],
            [
                'id_car' => 1,
                'id_user' => 1
            ]
        ]);
    }
}
