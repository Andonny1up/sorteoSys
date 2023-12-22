<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateBreadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->call([
            DataTypesTableSeeder::class,
            DataRowsTableSeeder::class,
            MenuItemsTableSeeder::class,
        ]);
    }
}
