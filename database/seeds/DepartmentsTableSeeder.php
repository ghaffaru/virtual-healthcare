<?php

use Illuminate\Database\Seeder;
use App\Department;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create([

            'department' => 'Pharmacy'
        ]);

        Department::create([

            'department' => 'Intensive Care Unit'
        ]);

        Department::create([

            'department' => 'OPD'
        ]);

        Department::create([

            'department' => 'Information Technology '
        ]);

        Department::create([

            'department' => 'Accounts and Finance'
        ]);

        Department::create([

            'department' => 'Purchasing and Supply'
        ]);

        Department::create([

            'department' => 'Cardiology'
        ]);
    }
}
