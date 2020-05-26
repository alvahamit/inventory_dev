<?php

use Illuminate\Database\Seeder;

class MoneyReceiptsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       //using factory class.
        factory(App\MoneyReceipt::class, 10)->create();
    }
}
