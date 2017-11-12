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
            $table->increments('id');
            $table->string('surname', 20)->default(null);
            $table->string('name', 15)->default(null);
            $table->string('patronymic', 20)->default(null);
            $table->string('position', 30)->default(null);
            $table->integer('year_birth')->default(0);
            $table->integer('year_salary')->default(0);
            $table->string('currency', 10)->default('грн');
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
