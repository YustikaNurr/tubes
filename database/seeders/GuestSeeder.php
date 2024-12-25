<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('guest')->insert([
            [
                'firstname' => 'Devina',
                'lastname' => 'Putri',
                'email'=> 'devinaputri@gmail.com',
                'contact' => 812345678,
            ],
        ]);
    }
}
