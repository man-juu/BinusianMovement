<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('users')->insert([
            'nim' => '2440011740',
            'nama' => 'Jonathan',
            'email' => 'jonathan@gmail.com',
            'password' => bcrypt('jojo123'),
            'role' => 'admin'
        ]);
    }
}
