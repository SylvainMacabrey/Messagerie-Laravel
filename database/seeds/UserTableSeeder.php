<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 10; $i++) {
            DB::table('users')->insert([
                'name' => "John$i",
                'email' => "john$i@gmail.com",
                'password' => bcrypt('azerty')
            ]);
        }
    }
}
