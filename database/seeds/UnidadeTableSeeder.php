<?php

use Illuminate\Database\Seeder;
use App\Models\Unidade;

class UnidadeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unidades = [
            ['nome' => 'Address SP (Matriz)', 'descricao' => 'Unidade Address da Cidade de São Paulo'],
            ['nome' => 'Address RJ', 'descricao' => 'Unidade Address da Cidade do Rio de Janeiro'],
            ['nome' => 'Address BH', 'descricao' => 'Unidade Address da Cidade de Belo Horizonte'],
            ['nome' => 'Address Curitiba', 'descricao' => 'Unidade Address da Cidade de Curitiba'],
            ['nome' => 'Address Salvador', 'descricao' => 'Unidade Address da Cidade de Salvador'],
            ['nome' => 'Address Campo Grande', 'descricao' => 'Unidade Address da Cidade de Campo Grande'],
            ['nome' => 'Address RS', 'descricao' => 'Unidade Address da Cidade de Porto Alegre'],
            ['nome' => 'Address Goiânia', 'descricao' => 'Unidade Address da Cidade de Goiânia'],
            ['nome' => 'Address Recife', 'descricao' => 'Unidade Address da Cidade de Recife'],
            ['nome' => 'Address Fortaleza', 'descricao' => 'Unidade Address da Cidade de Fortaleza'],
            ['nome' => 'Address Belém', 'descricao' => 'Unidade Address da Cidade de Belém'],
            ['nome' => 'Address Florianópolis', 'descricao' => 'Unidade Address da Cidade de Florianópolis'],
            ['nome' => 'Address Brasília', 'descricao' => 'Unidade Address da Cidade de Brasília'],
            ['nome' => 'Address Manaus', 'descricao' => 'Unidade Address da Cidade de Manaus'],
        ];

        foreach ($unidades as $unidade) {
            Unidade::create($unidade);
        }
    }
}
