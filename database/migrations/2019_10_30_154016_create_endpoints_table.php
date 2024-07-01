<?php

use App\Endpoint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEndpointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $database_type = env('DB_CONNECTION','mysql');

        if($database_type!='mysql')
        {
            Schema::create('endpoints', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger( 'endpoint_type_id' )->nullable();
                $table->string('name')->nullable();
                $table->string('description')->nullable();
                $table->string('endpoint_url')->nullable();
                $table->string('notify_url')->nullable();
                $table->string('bcc')->nullable();
                $table->string('footnote')->nullable();
                $table->string('cost_type')->nullable();//v=variable, c=constant
                $table->decimal('cost_per_unit', 9, 2);
                $table->string('pay_url')->nullable();
                $table->timestamps();
            });

            $sql = "ALTER TABLE endpoints ALTER COLUMN description NVARCHAR(MAX)";
            DB::statement($sql);

            $sql = "ALTER TABLE endpoints ALTER COLUMN endpoint_url NVARCHAR(MAX)";
            DB::statement($sql);

            $sql = "ALTER TABLE endpoints ALTER COLUMN notify_url NVARCHAR(MAX)";
            DB::statement($sql);

            $sql = "ALTER TABLE endpoints ALTER COLUMN bcc NVARCHAR(MAX)";
            DB::statement($sql);

            $sql = "ALTER TABLE endpoints ALTER COLUMN footnote NVARCHAR(MAX)";
            DB::statement($sql);

            $sql = "ALTER TABLE endpoints ALTER COLUMN endpoint_url NVARCHAR(MAX)";
            DB::statement($sql);
        }
        else
        {
            Schema::create('endpoints', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('endpoint_type_id')->nullable();
                $table->string('name')->nullable();
                $table->text('description')->nullable();
                $table->text('endpoint_url')->nullable();
                $table->text('notify_url')->nullable();
                $table->text('bcc')->nullable();
                $table->text('footnote')->nullable();
                $table->string('cost_type')->nullable(); //v=variable, c=constant
                $table->decimal('cost_per_unit', 9, 2);
                $table->text('pay_url')->nullable();
                $table->timestamps();
            });
        }

        $attributes['endpoint_type_id'] = 2;//form
        $attributes['name']             = 'Summer Programmes';
        $attributes['description']      = 'Summer Holiday Programmes';
        $attributes['endpoint_url']     = 'https://applications.harrowschool.ac.th/uat-naet/SummerProgram/';
        $attributes['notify_url']       = 'https://applications.harrowschool.ac.th/uat-naet/SummerProgram/order-notify.php';
        $attributes['bcc']              = 'naet_ph@harrowschool.ac.th';
        $attributes['footnote']         = 'We have received your payment of Summer Programme.<br>* Should you have any urgent requests please contact holidayprogrammes@harrowschool.ac.th';
        $attributes['cost_type']        = 'v';
        $attributes['cost_per_unit']    = 1;
        $attributes['pay_url']          = 'https://histest.harrowschool.ac.th/gate/public/order';
        Endpoint::create( $attributes );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('endpoints');
    }
}
