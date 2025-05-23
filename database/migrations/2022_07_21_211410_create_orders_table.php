<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code');
            $table->longText('note')->nullable();
            $table->dateTime('order_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('subtotal')->default(0);
            $table->integer('discount')->default(0);
            $table->integer('total')->default(0);
            $table->integer('status_id');
            $table->integer('employee_onduty_id')->nullable();
            $table->integer('store_id')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
