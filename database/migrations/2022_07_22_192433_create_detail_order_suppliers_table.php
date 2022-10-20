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
        Schema::create('detail_order_suppliers', function (Blueprint $table) {
            $table->id();
            $table->integer('order_supplier_id');
            $table->integer('product_id');
            $table->integer('request_qty');
            $table->string('request_unit');
            $table->string('receive_unit')->nullable();
            $table->integer('quantity_per_unit')->nullable();
            $table->integer('receive_qty')->nullable();
            $table->integer('price_per_unit')->nullable();
            $table->integer('subtotal')->nullable();
            $table->integer('all_quantity_in_units')->nullable();
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
        Schema::dropIfExists('detail_order_suppliers');
    }
};
