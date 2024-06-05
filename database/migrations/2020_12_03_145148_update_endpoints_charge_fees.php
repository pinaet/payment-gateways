<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Endpoint;

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
        $endpoint             = Endpoint::find(4); //Christmas Programme
        $endpoint->charge_fee = 'n';
        $endpoint->save();
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
