<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Cristian Araya J',
            'email' => 'cristian0789@gmail.com',
            'password' => bcrypt('admin123')
        ]);
    }
}
