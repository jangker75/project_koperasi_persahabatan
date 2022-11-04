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
        Schema::create('return_suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('return_supplier_code');
            $table->integer('supplier_id');
            $table->integer('status_return_id');
            $table->integer('status_ticket_id');
            $table->integer('submit_employee_id');
            $table->string('note');
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
        Schema::dropIfExists('return_suppliers');
    }
};
