<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEndpointsChargeFees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('endpoints', function (Blueprint $table) {
            $table->string('charge_fee',1)->nullable(); //y=yes, n=no
        });

        //set charge_fee to all endpoints
        $sql = "
            update endpoints
            set charge_fee='y'
        ";
        DB::statement( $sql );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('endpoints', function (Blueprint $table) {
            $table->dropColumn('charge_fee');
        });
    }
}
