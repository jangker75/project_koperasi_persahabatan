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
        Schema::create('return_supplier_details', function (Blueprint $table) {
            $table->id();
            $table->integer('return_supplier_id');
            $table->integer('product_id');
            $table->integer('qty');
            $table->string('description')->nullable();
            $table->integer('price')->nullable();
            $table->integer('amount')->nullable();
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
        Schema::dropIfExists('return_supplier_details');
    }
};
