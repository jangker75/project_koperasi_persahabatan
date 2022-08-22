<?php

use Carbon\Carbon;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->integer('amount');
            $table->boolean('is_paylater')->default(0);
            $table->integer('status_transaction_id')->default(4);
            $table->integer('status_paylater_id')->nullable();
            $table->datetime('transaction_date')->default(Carbon::now());
            $table->enum("type", ["in", "out"])->default('in');
            $table->integer("payment_method_id")->default(1);
            $table->string("payment_code")->nullable();
            $table->integer("requester_employee_id")->nullable();
            $table->integer("approval_employee_id")->nullable();
            $table->datetime("request_date")->nullable();
            $table->datetime("approve_date")->nullable();
            $table->string("evidance")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
