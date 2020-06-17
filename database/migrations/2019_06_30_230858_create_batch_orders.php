<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBatchOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batch_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('patient_id');
            $table->string('id_prefix')->nullable();
            $table->string('or_number')->nullable();
            $table->text('clinical_information')->nullable();
            $table->text('special_instructions')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('is_urgent')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('batch_orders');
    }
}
