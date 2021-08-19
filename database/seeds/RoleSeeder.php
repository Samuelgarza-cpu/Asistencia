<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'Trabajador Social',
            'code' => 'TrSo'
        ]);
        DB::table('roles')->insert([
            'name' => 'Soporte',
            'code' => 'Soport'
        ]);
        DB::table('roles')->insert([
            'name' => 'Contador',
            'code' => 'Cont'
        ]);
        DB::table('roles')->insert([
            'name' => 'Dirección General',
            'code' => 'DirGen'
        ]);
        DB::table('roles')->insert([
            'name' => 'Coordinador de Asistencia Social',
            'code' => 'CoordiAsSo'
        ]);

        DB::table('roles')->insert([
            'name' => 'Supervisor de Asistencia Social',
            'code' => 'SuperAsSo'
        ]);
    }
}
