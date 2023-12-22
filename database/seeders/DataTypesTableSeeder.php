<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DataTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('data_types')->delete();
        
        \DB::table('data_types')->insert(array (
            0 => 
            array (
                'controller' => 'TCG\\Voyager\\Http\\Controllers\\VoyagerUserController',
                'created_at' => '2023-12-22 12:28:52',
                'description' => '',
                'details' => NULL,
                'display_name_plural' => 'Users',
                'display_name_singular' => 'User',
                'generate_permissions' => 1,
                'icon' => 'voyager-person',
                'id' => 1,
                'model_name' => 'TCG\\Voyager\\Models\\User',
                'name' => 'users',
                'policy_name' => 'TCG\\Voyager\\Policies\\UserPolicy',
                'server_side' => 0,
                'slug' => 'users',
                'updated_at' => '2023-12-22 12:28:52',
            ),
            1 => 
            array (
                'controller' => '',
                'created_at' => '2023-12-22 12:28:52',
                'description' => '',
                'details' => NULL,
                'display_name_plural' => 'Menus',
                'display_name_singular' => 'Menu',
                'generate_permissions' => 1,
                'icon' => 'voyager-list',
                'id' => 2,
                'model_name' => 'TCG\\Voyager\\Models\\Menu',
                'name' => 'menus',
                'policy_name' => NULL,
                'server_side' => 0,
                'slug' => 'menus',
                'updated_at' => '2023-12-22 12:28:52',
            ),
            2 => 
            array (
                'controller' => 'TCG\\Voyager\\Http\\Controllers\\VoyagerRoleController',
                'created_at' => '2023-12-22 12:28:52',
                'description' => '',
                'details' => NULL,
                'display_name_plural' => 'Roles',
                'display_name_singular' => 'Role',
                'generate_permissions' => 1,
                'icon' => 'voyager-lock',
                'id' => 3,
                'model_name' => 'TCG\\Voyager\\Models\\Role',
                'name' => 'roles',
                'policy_name' => NULL,
                'server_side' => 0,
                'slug' => 'roles',
                'updated_at' => '2023-12-22 12:28:52',
            ),
            3 => 
            array (
                'controller' => NULL,
                'created_at' => '2023-12-22 20:56:47',
                'description' => NULL,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}',
                'display_name_plural' => 'Personas',
                'display_name_singular' => 'Persona',
                'generate_permissions' => 1,
                'icon' => 'voyager-people',
                'id' => 5,
                'model_name' => 'App\\Models\\Person',
                'name' => 'people',
                'policy_name' => NULL,
                'server_side' => 0,
                'slug' => 'personas',
                'updated_at' => '2023-12-22 21:43:50',
            ),
            4 => 
            array (
                'controller' => NULL,
                'created_at' => '2023-12-22 21:29:55',
                'description' => NULL,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}',
                'display_name_plural' => 'Sorteos',
                'display_name_singular' => 'Sorteo',
                'generate_permissions' => 1,
                'icon' => 'voyager-tag',
                'id' => 6,
                'model_name' => 'App\\Models\\Raffle',
                'name' => 'raffles',
                'policy_name' => NULL,
                'server_side' => 0,
                'slug' => 'raffles',
                'updated_at' => '2023-12-22 21:33:30',
            ),
        ));
        
        
    }
}