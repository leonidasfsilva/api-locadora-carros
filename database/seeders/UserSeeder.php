<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Marshall Mathers',
                'email' => 'marshall@email.com'
            ],
            [
                'name' => ' Andre Young',
                'email' => 'andre@email.com'
            ],
            [
                'name' => ' Curtis Jackson',
                'email' => 'curtis@email.com'
            ]
        ]);
    }
}
