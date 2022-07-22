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
            $table->string('last_name')->nullable();
            $table->string('nik');
            $table->string('nip')->nullable();
            $table->date('birthday');
            $table->string('gender', 50);
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('bank')->nullable();
            $table->string('rekening')->nullable();
            $table->date('registered_date')->nullable();
            $table->date('resign_date')->nullable();
            $table->integer('departement_id')->nullable();
            $table->integer('position_id')->nullable();
            $table->integer('status_employee_id')->nullable();
            $table->integer('salary')->default(0);
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
