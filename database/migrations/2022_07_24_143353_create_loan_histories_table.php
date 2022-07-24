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
        Schema::create('loan_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('loan_id');
            $table->string('transaction_type', 100);
            $table->date('transaction_date');
            $table->bigInteger('total_payment')->default(0);
            $table->bigInteger('interest_amount')->default(0);
            $table->bigInteger('loan_amount_before')->default(0);
            $table->bigInteger('loan_amount_after')->default(0);
            $table->bigInteger('profit_company_amount')->default(0);
            $table->bigInteger('profit_employee_amount')->default(0);
            $table->string('description', 250)->nullable();
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
        Schema::dropIfExists('loan_histories');
    }
};
