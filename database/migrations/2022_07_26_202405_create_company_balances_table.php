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
        Schema::create('company_balances', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->bigInteger('loan_balance')->default(0);
            $table->bigInteger('store_balance')->default(0);
            $table->bigInteger('other_balance')->default(0);
            $table->bigInteger('total_balance')->default(0);
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
        Schema::dropIfExists('company_balances');
    }
};
