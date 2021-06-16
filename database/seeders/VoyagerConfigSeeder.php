<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VoyagerConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared(file_get_contents('storage\voyager config seed\data_types.sql'));
        DB::unprepared(file_get_contents('storage\voyager config seed\menus.sql'));
        DB::unprepared(file_get_contents('storage\voyager config seed\roles.sql'));
        DB::unprepared(file_get_contents('storage\voyager config seed\settings.sql'));
        DB::unprepared(file_get_contents('storage\voyager config seed\permission_role.sql'));
        DB::unprepared(file_get_contents('storage\voyager config seed\menu_items.sql'));
        DB::unprepared(file_get_contents('storage\voyager config seed\data_rows.sql'));
    }
}
