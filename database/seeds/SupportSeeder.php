<?php

use Illuminate\Database\Seeder;

class SupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('supports')->insert([
            'name' => 'Implementos ortopedicos',
            'code' => 'ImOr',

        ]);
        DB::table('supports')->insert([
            'name' => 'General',
            'code' => 'Gene',

        ]);
        DB::table('supports')->insert([
            'name' => 'Medicamentos',
            'code' => 'Medi',

        ]);
        DB::table('supports')->insert([
            'name' => 'Funeraria',
            'code' => 'Fune',

        ]);
        DB::table('supports')->insert([
            'name' => 'Estudios Medicos',
            'code' => 'EsMe',

        ]);
        DB::table('supports')->insert([
            'name' => 'General hospitalario',
            'code' => 'ApOr',

        ]);
        DB::table('supports')->insert([
            'name' => 'Lentes',
            'code' => 'ApOr',

        ]);
        DB::table('supports')->insert([
            'name' => 'Despensas',
            'code' => 'Desp',

        ]);
        DB::table('supports')->insert([
            'name' => 'Aparatos ortopedicos',
            'code' => 'Apar',

        ]);
        DB::table('supports')->insert([
            'name' => 'Transporte',
            'code' => 'Tran',

        ]);
        DB::table('supports')->insert([
            'name' => 'Viajes',
            'code' => 'Viaj',

        ]);
    }
}
