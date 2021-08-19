<?php

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status')->insert([
            'name' => 'Pendiente Anexo Archivos',
            'code' => 'PAA'
        ]);
        DB::table('status')->insert([
            'name' => 'Autorizada Pendiente Factura',
            'code' => 'APF'
        ]);
        DB::table('status')->insert([
            'name' => 'Autorizada',
            'code' => 'AUT'
        ]);
        DB::table('status')->insert([
            'name' => 'Rechazada',
            'code' => 'REC'
        ]);
        DB::table('status')->insert([
            'name' => 'Finalizada',
            'code' => 'FIN'
        ]);
        DB::table('status')->insert([
            'name' => 'Cancelada',
            'code' => 'CAN'
        ]);
        DB::table('status')->insert([
            'name' => 'Inconclusa',
            'code' => 'INC'
        ]);
        
    }
}
