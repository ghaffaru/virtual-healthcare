<?php

use Illuminate\Database\Seeder;
use App\StaffType;

class StaffTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        #same as employee type

        StaffType::create([
            
            'staff_type' => 'Physician'
        ]);

        StaffType::create([
            
            'staff_type' => 'Nurse'
        ]);

        StaffType::create([
            
            'staff_type' => 'Therapist'
        ]);

        StaffType::create([
            
            'staff_type' => 'Pharmacist'
        ]);


        StaffType::create([
            
            'staff_type' => 'Dietition'
        ]);

        StaffType::create([
            
            'staff_type' => 'Information Technology'
        ]);

        StaffType::create([
            
            'staff_type' => 'Tech' # radiology tech, ultrasound tech
        ]);


        StaffType::create([
            
            'staff_type' => 'Accountant'
        ]);


        StaffType::create([
            
            'staff_type' => 'Dentist'
        ]);



        StaffType::create([
            
            'staff_type' => 'Ward Clerk'
        ]);
    }
}
