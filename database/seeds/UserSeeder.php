<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status')->insert([
            'name' => 'admin',
            'password' => Hash::make('admin123'),
            'email' => '',
            'signature' => '',
            'active' => '',
            'owner' => 'Administrador',
            'roles_id' => 2,
            'departments_institutes_id' => ''
        ]);

    }
}
