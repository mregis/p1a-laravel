<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        \App\User::create([
            "id"=>1,
            "email" => "rodrigo@luby.com.br",
            "password" => Hash::make("admin"),
            "name"=>"Rodrigo Gardin"
        ]);
        \App\User::create([
            "id"=>2,
            "email" => "nikolas@luby.com.br",
            "password" => Hash::make("admin"),
            "name"=>"Nikolas Fernander"
        ]);
        \App\User::create([
            "id"=>3,
            "email" => "flavio@luby.com.br",
            "password" => Hash::make("admin"),
            "name"=>"Flávio Apolinário"
        ]);
        \App\User::create([
            "id"=>4,
            "email" => "jancarlo@luby.com.br",
            "password" => Hash::make("admin"),
            "name"=>"Jancarlo Romero"
        ]);
    }
}
