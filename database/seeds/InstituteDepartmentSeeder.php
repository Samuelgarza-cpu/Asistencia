<?php

use Illuminate\Database\Seeder;

class InstituteDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('departments_institutes')->insert([
            'departments_id' => 1,
            'institutes_id' => 1
            
        ]);
        DB::table('departments_institutes')->insert([
            'departments_id' => 2,
            'institutes_id' => 1
            
        ]);
        DB::table('departments_institutes')->insert([
            'departments_id' => 3,
            'institutes_id' => 2
            
        ]);
        DB::table('departments_institutes')->insert([
            'departments_id' => 4,
            'institutes_id' => 2
            
        ]);
        DB::table('departments_institutes')->insert([
            'departments_id' => 5,
            'institutes_id' => 2
            
        ]);
    }
}
