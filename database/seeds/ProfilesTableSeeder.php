<?php

use Illuminate\Database\Seeder;
use App\Models\Profile;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profile::create([
            "nome" => "ADMINISTRADOR",
            "descricao" => "Administrdor do Sistema",
        ]);
        Profile::create([
            "nome" => "OPERADOR",
            "descricao" => "Operador padrão do Sistema",
        ]);
        Profile::create([
            "nome" => "DEPARTAMENTO",
            "descricao" => "Conta de Departamento",
        ]);
        Profile::create([
            "nome" => "AGENCIA",
            "descricao" => "Conta de Agência",
        ]);
    }
}
