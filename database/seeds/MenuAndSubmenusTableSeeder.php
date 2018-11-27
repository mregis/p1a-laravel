<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Sub_Menu;

class MenuAndSubmenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Menu Usuários
        $menu = Menu::create([
            "name" => "Usuários",
            "icon" => "fa fa-users",
            "url" => "/users",
            "item_order" => 7,
        ]);
        // SubMenus para Menu Usuários
        Sub_Menu::create([
            "name" => "Listar",
            "icon" => "fa fa-list-ul",
            "url" => "/list",
            "item_order" => 1,
            "menu_id" => $menu->id,
        ]);
        Sub_Menu::create([
            "name" => "Adicionar",
            "icon" => "fa fa-plus-circle",
            "url" => "/add",
            "item_order" => 2,
            "menu_id" => $menu->id,
        ]);

        // Menu Relatórios
        $menu = Menu::create([
            "name" => "Relatórios",
            "icon" => "fa fa-file-text-o",
            "url" => "/reports",
            "item_order" => 6,
        ]);
        // SubMenus para Menu Relatórios
        Sub_Menu::create([
            "name" => "Geral",
            "icon" => "fa fa-file-text",
            "url" => "/remessa",
            "item_order" => 1,
            "menu_id" => $menu->id,
        ]);

        // Menu Dashboard
        Menu::create([
            "name" => "Dashboard",
            "icon" => "fa fa-dashboard",
            "url" => "/dashboard",
            "item_order" => 1,
        ]);

        // Menu Remessa
        $menu = Menu::create([
            "name" => "Remessa",
            "icon" => "fa fa-home",
            "item_order" => 2,
        ]);
        // SubMenus para Menu Remessa
        Sub_Menu::create([
            "name" => "Upload de Arquivos",
            "icon" => "fa fa-cloud-upload",
            "url" => "/upload/",
            "item_order" => 1,
            "menu_id" => $menu->id,
        ]);
        Sub_Menu::create([
            "name" => "Gestão de Arquivos",
            "icon" => "fa fa-file-text",
            "url" => "/arquivos/",
            "item_order" => 2,
            "menu_id" => $menu->id,
        ]);
        Sub_Menu::create([
            "name" => "Registrar",
            "icon" => "fa fa-plus-circle",
            "url" => "/remessa/registrar",
            "item_order" => 3,
            "menu_id" => $menu->id,
        ]);

        // Menu Recebimento
        $menu = Menu::create([
            "name" => "Recebimento",
            "icon" => "fa fa-file-o",
            "item_order" => 4,
        ]);
        // SubMenus para Menu Recebimento
        Sub_Menu::create([
            "name" => "Agência",
            "icon" => "fa fa-external-link-square",
            "url" => "/receber/",
            "item_order" => 1,
            "menu_id" => $menu->id,
        ]);
        Sub_Menu::create([
            "name" => "Operador",
            "icon" => "fa fa-briefcase",
            "url" => "/receber-operador/",
            "item_order" => 2,
            "menu_id" => $menu->id,
        ]);
        Sub_Menu::create([
            "name" => "Todos",
            "icon" => "fa fa-list-ol",
            "url" => "/receber-todos/",
            "item_order" => 3,
            "menu_id" => $menu->id,
        ]);

        // Menu Ocorrências
        $menu = Menu::create([
            "name" => "Ocorrências",
            "icon" => "fa fa-newspaper-o",
            "item_order" => 5,
        ]);
        // SubMenu para Menu Ocorrências
        Sub_Menu::create([
            "name" => "Listar",
            "icon" => "fa fa-list-ul",
            "url" => "/ocorrencias/list",
            "item_order" => 1,
            "menu_id" => $menu->id,
        ]);
        Sub_Menu::create([
            "name" => "Adicionar",
            "icon" => "fa fa-plus-circle",
            "url" => "/ocorrencias/add",
            "item_order" => 2,
            "menu_id" => $menu->id,
        ]);

        // Menu Auditoria
        Menu::create([
            "name" => "Auditoria",
            "icon" => "fa fa-info-circle",
            "url" => "/auditoria",
            "item_order" => 8,
        ]);

        // Menu Cadastros
        $menu = Menu::create([
            "name" => "Cadastros",
            "icon" => "fa fa-edit",
            "url" => "/cadastros",
            "item_order" => 3,
        ]);
        // SubMenu para Menu Cadastros
        Sub_Menu::create([
            "name" => "Produtos",
            "icon" => "fa fa-briefcase",
            "url" => "/produtos",
            "item_order" => 1,
            "menu_id" => $menu->id,
        ]);
        Sub_Menu::create([
            "name" => "Contigência",
            "icon" => "fa fa-plus-circle",
            "url" => "/contingencia/",
            "item_order" => 2,
            "menu_id" => $menu->id,
        ]);
        Sub_Menu::create([
            "name" => "Perfis",
            "icon" => "fa fa-user-circle",
            "url" => "/perfil",
            "item_order" => 3,
            "menu_id" => $menu->id,
        ]);

    }
}
