<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
         User::create([
            'name' =>"Admin",
            'email' => "admin@gmail.com",
            'password' =>bcrypt('password'),
            'type'=>'Superadministrator'
        ])->attachRole('Superadministrator');
        User::create([
            'name' =>"Mustafa",
            'email' => "mustafa@gmail.com",
            'password' =>bcrypt('12344321'),
            'type'=>'administrator'
        ])->attachRole('administrator');
    
    }
}
