<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Hamza abu jahal',
            'email' => 'h@jahal.ps',
            'password' => Hash::make('password'),
            'phone_number' => '0592971916',
        ]);

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'A@abu.ps',
            'password' => Hash::make('password'),
            'phone_number' => '0592262801',
        ]);
    }
}
