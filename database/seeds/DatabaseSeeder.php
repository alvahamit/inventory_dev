<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Model table seeders
        $this->call(RolesTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(MeasurementsTableSeeder::class);
        $this->call(StoresTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(AddressesTableSeeder::class);
        $this->call(ContactsTableSeeder::class);
        $this->call(PurchasesTableSeeder::class);
        $this->call(MoneyReceiptsTableSeeder::class);
        //Pivot table seeders
        $this->call(PackingsTableSeeder::class);
        $this->call(CategoryProductTableSeeder::class);
        $this->call(CountryProductTableSeeder::class);
        $this->call(RoleUserTableSeeder::class);
        $this->call(ProductPurchaseTableSeeder::class);
        $this->call(ContactablesTableSeeder::class);
        $this->call(AddressablesTableSeeder::class);
         
         
    }
}
