<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email_address')->nullable();
            $table->string('phone_number');
            $table->date('date_of_birth')->nullable();
            $table->string('province_address')->nullable();
            $table->string('city_address')->nullable();
            $table->longText('street_address')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('ktp_number');
            $table->string('ktp_files');
            $table->string('current_position')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bank_account_number')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
