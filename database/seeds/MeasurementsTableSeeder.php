<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MeasurementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //table name
        $table = 'measurements';
        //data
        DB::table($table)->insert([
            'unit' => 'Kilogram',
            'short' => 'kg',
            'used_for' => 'Weight measurement',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table($table)->insert([
            'unit' => 'Gram',
            'short' => 'gm',
            'used_for' => 'Weight measurement',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table($table)->insert([
            'unit' => 'Litre',
            'short' => 'ltr',
            'used_for' => 'Liquid volume measurement',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table($table)->insert([
            'unit' => 'Mililitre',
            'short' => 'ml',
            'used_for' => 'Liquid volume measurement',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
