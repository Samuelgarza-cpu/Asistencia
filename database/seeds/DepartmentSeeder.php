<?php

use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            'name' => 'Informática General',
            'code' => 'InGe'
        ]);
        DB::table('departments')->insert([
            'name' => 'Informática',
            'code' => 'Info'
        ]);
        DB::table('departments')->insert([
            'name' => 'Dirección General',
            'code' => 'DiGe'
        ]);
        DB::table('departments')->insert([
            'name' => 'Asistencia Social',
            'code' => 'AsSo'
        ]);
        DB::table('departments')->insert([
            'name' => 'Contaduria',
            'code' => 'Conta'
        ]);
    }
}
