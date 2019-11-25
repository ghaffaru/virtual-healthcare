<?php

use Illuminate\Database\Seeder;
use App\Pharmacy;

class PharmacyDrugsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Pharmacy::create([
            'drug_name' => 'paracetamol',
            'quantity' => 21,
            'price' => 10.0
        ]);

        Pharmacy::create([
            'drug_name' => 'zulu100',
            'quantity' => 7,
            'price' => 12.5
        ]);


        Pharmacy::create([
            'drug_name' => 'gebedol',
            'quantity' => 6,
            'price' => 7.5
        ]);

        Pharmacy::create([
            'drug_name' => 'tramadol',
            'quantity' => 10,
            'price' => 9.5
        ]);

        Pharmacy::create([
            'drug_name' => 'martins liver salt',
            'quantity' => 5,
            'price' => 7.0
        ]);
    }
}
