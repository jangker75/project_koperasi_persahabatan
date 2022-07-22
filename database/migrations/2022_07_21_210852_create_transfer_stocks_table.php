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
        Schema::create('transfer_stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('from_store_id');
            $table->integer('to_store_id');
            $table->integer('send_qty');
            $table->integer('receive_qty')->nullable();
            $table->integer('status_id')->nullable();
            $table->integer('req_empl_id');
            $table->integer('send_empl_id')->nullable();
            $table->datetime('order_date');
            $table->datetime('send_date')->nullable();
            $table->datetime('receive_date')->nullable();
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
        Schema::dropIfExists('transfer_stocks');
    }
};
