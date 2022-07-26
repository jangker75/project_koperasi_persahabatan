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
        Schema::create('company_balance_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('balance_id');
            $table->string('balance_type', 100);
            $table->bigInteger('amount');
            $table->string('transaction_type', 100);
            $table->timestamp('transaction_date');
            $table->bigInteger('balance_before');
            $table->bigInteger('balance_after');
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
        Schema::dropIfExists('company_balance_histories');
    }
};
