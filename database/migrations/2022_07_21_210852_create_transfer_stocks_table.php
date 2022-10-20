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
            $table->string('transfer_stock_code');
            $table->integer('from_store_id');
            $table->integer('to_store_id');
            $table->integer('status_id')->nullable();
            $table->integer('req_empl_id');
            $table->integer('send_empl_id')->nullable();
            $table->datetime('req_date');
            $table->longtext('note')->nullable();
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
