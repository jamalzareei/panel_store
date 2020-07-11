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
        // $this->call(UserSeeder::class);
        $this->call([
            UserSeed::class,
            CategorySeed::class,
            AddressSeed::class,
            ExtraFieldSeed::class,
            FinanceSeed::class,
            ImageSeed::class,
            PageSeed::class,
            PermissionSeed::class,
            PriceSeed::class,
            RoleSeed::class,
            ProductSeed::class,
            ReviewSeed::class,
            SellerSeed::class,
            SosialSeed::class,
            SupplierSeed::class,
            CountriesTableSeeder::class,
            StatesTableSeeder::class,
            CitiesTableSeeder::class

        ]);
    }
}
