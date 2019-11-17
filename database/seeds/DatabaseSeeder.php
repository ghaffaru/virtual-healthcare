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
        $this->call(StaffTypesTableSeeder::class);
        $this->call(SpecializationsTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
    }
}
