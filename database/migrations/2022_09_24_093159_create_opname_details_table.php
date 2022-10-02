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
        Schema::create('opname_details', function (Blueprint $table) {
            $table->id();
            $table->integer('opname_id');
            $table->integer('product_id');
            $table->integer('quantity');
            $table->enum('type', ['minus', 'plus'])->default('minus');
            $table->string('description')->nullable();
            $table->integer('price');
            $table->integer('amount');
            $table->boolean('is_expired')->nullable();
            $table->boolean('expired_is_returned')->nullable();
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
        Schema::dropIfExists('opname_details');
    }
};
