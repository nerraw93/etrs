<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBatchOrderTests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batch_order_tests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('batch_order_id');
            $table->unsignedBigInteger('service_id');
            $table->integer('samples');
            $table->float('costs');
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
        Schema::dropIfExists('batch_order_tests');
    }
}
