<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            //$table->foreign('user_id')->references('id')->on('user');
            //$table->Increments('prescription_id');
            $table->integer('user_id');
            $table->integer('doctor_id');
            $table->string('case_history');
            $table->string('medication');
            // $table->string('medication_from_pharmacist');
            $table->string('submitted')->default(false);
            $table->string('drug_issued')->default(false);
            $table->double('total_amount')->default(0.0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescriptions');
    }
}
