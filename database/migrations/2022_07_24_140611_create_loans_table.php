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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->bigInteger('total_loan_amount');
            $table->bigInteger('remaining_amount');
            $table->bigInteger('received_amount');
            $table->integer('contract_type_id');
            $table->string('transaction_number', 50);
            $table->date('loan_date');
            $table->integer('admin_fee')->default(0);
            $table->double('interest_amount')->default(0);
            $table->string('interest_amount_type', 50);
            $table->integer('interest_scheme_type_id');
            $table->double('profit_company_ratio')->default(50);
            $table->double('profit_employee_ratio')->default(50);
            $table->integer('total_pay_month');
            $table->integer('pay_per_x_month')->default(1);
            $table->date('first_payment_date');
            $table->text('notes')->nullable();
            $table->string('attachment', 250)->nullable();
            $table->integer('loan_approval_status_id');
            $table->integer('is_lunas')->default(0);
            $table->timestamp('response_date')->nullable();
            $table->string('response_user', 100)->nullable();
            $table->string('created_by', 100)->nullable();
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
        Schema::dropIfExists('loans');
    }
};
