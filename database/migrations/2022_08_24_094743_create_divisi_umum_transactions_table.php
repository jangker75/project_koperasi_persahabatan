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
        Schema::create('divisi_umum_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_type',100);
            $table->integer('user_id');
            $table->integer('amount');
            $table->timestamp('transaction_date')->nullable();
            $table->string('description',250)->nullable();
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
        Schema::dropIfExists('divisi_umum_transactions');
    }
};
