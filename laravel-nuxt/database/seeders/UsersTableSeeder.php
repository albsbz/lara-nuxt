<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => Hash::make('testpass'), // password
            'remember_token' => Str::random(10),
        ]);
        DB::table('role_user')->insert([
            'user_id' => '1',
            'role_id' => '3',
        ]);

        $roles = Role::all();
        User::factory(50)->create()->each(function ($user) use ($roles) {
            $user->roles()->attach('1');
        });
    }
}
