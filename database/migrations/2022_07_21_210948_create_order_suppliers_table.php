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
        Schema::create('order_suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('order_supplier_code');
            $table->integer('supplier_id');
            $table->integer('to_store_id');
            $table->integer('status_id');
            $table->integer('req_empl_id');
            $table->datetime('order_date');
            $table->datetime('received_date')->nullable();
            $table->longText('note')->nullable();
            $table->integer('total')->nullable();
            $table->boolean('is_paid')->nullable();
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
        Schema::dropIfExists('order_suppliers');
    }
};
