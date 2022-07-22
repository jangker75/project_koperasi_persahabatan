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
            $table->integer('send_qty');
            $table->integer('receive_qty');
            $table->integer('reject_qty');
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
