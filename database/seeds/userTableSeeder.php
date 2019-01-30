<?php

use Illuminate\Database\Seeder;
use App\User;
class userTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        	'name' => 'adit',
        	'email' => 'adit@mail.com',
        	'password' => bcrypt('silent'),
        	'status' => true
        ]);
    }
}
