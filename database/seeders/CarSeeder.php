<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('cars')->insert([
            [
                'model' => 'Ecosport',
                'brand' => 'Ford',
                'plate' => 'LFS0U88'
            ],
            [
                'model' => 'Jetta',
                'brand' => 'Volkswagen',
                'plate' => 'OVS0E20'
            ],
            [
                'model' => 'Rampage',
                'brand' => 'RAM',
                'plate' => 'KIH5I65'
            ]
        ]);
    }
}
