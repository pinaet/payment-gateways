<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\EndpointType;

class CreateEndpointTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('endpoint_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('endpoint_type')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
        $attributes['endpoint_type'] = 'school'; $attributes['description'] = 'normally for school fees';        EndpointType::create( $attributes );
        $attributes['endpoint_type'] = 'form';   $attributes['description'] = 'normally for holiday programes';  EndpointType::create( $attributes );
        $attributes['endpoint_type'] = 'event';  $attributes['description'] = 'normally for google forms apps';  EndpointType::create( $attributes );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('endpoint_types');
    }
}
