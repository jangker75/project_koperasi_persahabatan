<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('nik');
            $table->string('nip');
            $table->date('birthday');
            $table->enum('gender', ['M','F']);
            $table->string('address_1');
            $table->string('address_2');
            $table->string('bank');
            $table->string('rekening');
            $table->date('registered_date');
            $table->date('resign_date')->nullable();
            $table->integer('departement_id')->nullable();
            $table->integer('position_id')->nullable();
            $table->integer('status_employee_id')->nullable();
            $table->integer('salary')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
};
