<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Sub_Menu;
use Illuminate\Support\Facades\DB;

class MenuAndSubmenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        ##### Menu Painel de Controle
        Menu::create([
            "name" => "Painel de Controle",
            "icon" => "fas fa-tachometer-alt",
            "url" => "painel", // Antigo dashboard
            "item_order" => 1,
        ]);

        ##### Menu Remessa (Envio)
        $menu = Menu::create([
            "name" => "Remessa (Envio)",
            "icon" => "fa fa-home",
            "item_order" => 2,
        ]);
        // SubMenus para Menu Remessa
        Sub_Menu::create([
            "name" => "Registrar",
            "icon" => "fas fa-list-ol",
            "url" => "remessa.registrar",
            "item_order" => 1,
            "menu_id" => $menu->id,
        ]);
        Sub_Menu::create([
            "name" => "Gestão de Arquivos",
            "icon" => "fas fa-file-alt",
            "url" => "remessa.listagem",
            "item_order" => 2,
            "menu_id" => $menu->id,
        ]);
        Sub_Menu::create([
            "name" => "Carregar Arquivos",
            "icon" => "fas fa-cloud-upload-alt",
            "url" => "remessa.carregar",
            "item_order" => 3,
            "menu_id" => $menu->id,
        ]);
        Sub_Menu::create([
            "name" => "Capa Avulsa",
            "icon" => "fas fa-envelope-open-text",
            "url" => "capalote.contingencia",
            "item_order" => 4,
            "menu_id" => $menu->id,
        ]);

        ##### Menu Cadastros
        $menu = Menu::create([
            "name" => "Cadastros",
            "icon" => "fa fa-edit",
            "item_order" => 3,
        ]);
        // SubMenu para Menu Cadastros
        Sub_Menu::create([
            "name" => "Produtos",
            "icon" => "fas fa-briefcase",
            "url" => "cadastro.produtos",
            "item_order" => 1,
            "menu_id" => $menu->id,
        ]);
        Sub_Menu::create([
            "name" => "Perfis",
            "icon" => "fa fas fa-user-circle",
            "url" => "cadastro.perfis",
            "item_order" => 2,
            "menu_id" => $menu->id,
        ]);
        Sub_Menu::create([
            "name" => "Agencias",
            "icon" => "fas fa-building",
            "url" => "cadastro.agencias",
            "item_order" => 3,
            "menu_id" => $menu->id,
        ]);
        Sub_Menu::create([
            "name" => "Unidades",
            "icon" => "fas fa-warehouse",
            "url" => "cadastro.unidades",
            "item_order" => 4,
            "menu_id" => $menu->id,
        ]);

        ##### Menu Recebimento
        $menu = Menu::create([
            "name" => "Recebimento",
            "icon" => "far fa-file",
            "item_order" => 4,
        ]);
        // SubMenus para Menu Recebimento
        Sub_Menu::create([
            "name" => "Agência",
            "icon" => "fas fa-external-link-square-alt",
            "url" => "recebimento.agencia",
            "item_order" => 1,
            "menu_id" => $menu->id,
        ]);
        Sub_Menu::create([
            "name" => "Todos",
            "icon" => "fas fa-list-ol",
            "url" => "recebimento.todos",
            "item_order" => 2,
            "menu_id" => $menu->id,
        ]);
        Sub_Menu::create([
            "name" => "Operador",
            "icon" => "fas fa-briefcase",
            "url" => "recebimento.operador",
            "item_order" => 3,
            "menu_id" => $menu->id,
        ]);
        Sub_Menu::create([
            "name" => "Ler de Arquivo",
            "icon" => "fa fa-list-ol",
            "url" => "recebimento.carregar-arquivo",
            "item_order" => 4,
            "menu_id" => $menu->id,
        ]);

        ##### Menu Ocorrências
        $menu = Menu::create([
            "name" => "Ocorrências",
            "icon" => "far fa-newspaper",
            "url" => "ocorrencias.listagem",
            "item_order" => 5,
        ]);

        ##### Menu Relatórios
        $menu = Menu::create([
            "name" => "Relatórios",
            "icon" => "far fa-file-alt",
            "item_order" => 6,
        ]);
        // SubMenus para Menu Relatórios
        Sub_Menu::create([
            "name" => "Geral",
            "icon" => "fas fa-file-alt",
            "url" => "relatorios.remessa",
            "item_order" => 1,
            "menu_id" => $menu->id,
        ]);
        Sub_Menu::create([
            "name" => "Analítico",
            "icon" => "fas fa-file-excel",
            "url" => "relatorios.analitico",
            "item_order" => 1,
            "menu_id" => $menu->id,
        ]);

        ##### Menu Usuários
        $menu = Menu::create([
            "name" => "Usuários",
            "icon" => "fas fa-users",
            "item_order" => 7,
        ]);
        // SubMenus para Menu Usuários
        Sub_Menu::create([
            "name" => "Listar",
            "icon" => "fas fa-list-ul",
            "url" => "usuarios.listar",
            "item_order" => 1,
            "menu_id" => $menu->id,
        ]);
        Sub_Menu::create([
            "name" => "Adicionar",
            "icon" => "fas fa-plus-circle",
            "url" => "usuarios.novo",
            "item_order" => 2,
            "menu_id" => $menu->id,
        ]);

        ##### Menu Auditoria
        Menu::create([
            "name" => "Auditoria",
            "icon" => "fa fa-info-circle",
            "url" => "auditoria.listar",
            "item_order" => 8,
        ]);

        ##### Menu Consulta
        $menu = Menu::create([
            "name" => "Consulta",
            "icon" => "fas fa-search",
            "item_order" => 9,
        ]);
        // SubMenus para Menu Consulta
        Sub_Menu::create([
            "name" => "Histórico",
            "icon" => "fas fa-list-ol",
            "url" => "capalote.listar",
            "item_order" => 1,
            "menu_id" => $menu->id,
        ]);
        Sub_Menu::create([
            "name" => "Individual",
            "icon" => "fas fa-envelope-square",
            "url" => "capalote.buscar",
            "item_order" => 2,
            "menu_id" => $menu->id,
        ]);
    }
}
