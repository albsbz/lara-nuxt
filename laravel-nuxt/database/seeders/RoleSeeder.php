<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Roles = DB::table('roles');

        $Roles->insert([
            'name' => 'user'
        ]);
        $Roles->insert([
            'name' => 'moderator'
        ]);
        $Roles->insert([
            'name' => 'admin'
        ]);
    }
}
