<?php

use Illuminate\Database\Seeder;

class MunicipalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('municipalities')->insert([
            'name' => 'Aguascalientes',
            'states_id' => 1
        ]);
        DB::table('municipalities')->insert([
            'name' => 'Asientos',
            'states_id' => 1
        ]);
        DB::table('municipalities')->insert([
            'name' => 'Calvillo',
            'states_id' => 1
        ]);
        DB::table('municipalities')->insert([
            'name' => 'Cosío',
            'states_id' => 1
        ]);
        DB::table('municipalities')->insert([
            'name' => 'El Llano',
            'states_id' => 1
        ]);
        DB::table('municipalities')->insert([
            'name' => 'Jesús María',
            'states_id' => 1
        ]);
        DB::table('municipalities')->insert([
            'name' => 'Pabellón de Arteaga',
            'states_id' => 1
        ]);
        DB::table('municipalities')->insert([
            'name' => 'Rincón de Romos',
            'states_id' => 1
        ]);
        DB::table('municipalities')->insert([
            'name' => 'San Francisco de los Romo',
            'states_id' => 1
        ]);
        DB::table('municipalities')->insert([
            'name' => 'San José de Gracia',
            'states_id' => 1
        ]);
        DB::table('municipalities')->insert([
            'name' => 'Tepezalá',
            'states_id' => 1
        ]);
        
        
        
        DB::table('municipalities')->insert([
            'name' => 'Jesús María',
            'states_id' => 2
        ]);




    }
}
