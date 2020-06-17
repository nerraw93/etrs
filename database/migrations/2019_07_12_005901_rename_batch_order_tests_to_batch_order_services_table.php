<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameBatchOrderTestsToBatchOrderServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('batch_order_tests', function (Blueprint $table) {
            $table->dropColumn('samples');
            $table->dropColumn('costs');
        });

        Schema::rename('batch_order_tests', 'batch_order_services');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
