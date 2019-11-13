<?php

use Illuminate\Database\Seeder;
use App\Specialization;

class SpecializationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Specialization::create([

            'specialization' => 'Dietetics'
        ]);


        Specialization::create([

            'specialization' => 'Radiology'
        ]);

        Specialization::create([

            'specialization' => 'Cardiology'
        ]);


        Specialization::create([

            'specialization' => 'Dermatology'
        ]);


        Specialization::create([

            'specialization' => 'General Surgury'
        ]);


        Specialization::create([

            'specialization' => 'Psychiatry'
        ]);


        Specialization::create([

            'specialization' => 'Hermatology'
        ]);
    }
}
