<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user1_id')->unsigned()->nullable();
            $table->integer('user2_id')->unsigned()->nullable();
            $table->boolean('staffschat')->nullable(); #staff to staff
            $table->boolean('doctorschat')->nullable(); #doctor to doctor
            $table->boolean('pharmacistschat')->nullable(); #pharmacist to pharmacist
            $table->boolean('doctor_patientschat')->nullable();
            $table->integer('department_id')->unsigned()->nullable(); #for group conversation 
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
        Schema::dropIfExists('conversations');
    }
}
