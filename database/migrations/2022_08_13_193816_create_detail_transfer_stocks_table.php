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
        Schema::create('detail_transfer_stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('transfer_stock_id');
            $table->integer('product_id');
            $table->integer('request_qty')->default(0);
            $table->integer('available_qty')->default(0);
            $table->integer('receive_qty')->default(0);
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
        Schema::dropIfExists('detail_transfer_stocks');
    }
};
