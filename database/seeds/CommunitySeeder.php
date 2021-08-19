<?php

use Illuminate\Database\Seeder;

class CommunitySeeder extends Seeder
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

        
    }
}
