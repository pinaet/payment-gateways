<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\SourceType;

class CreateSourceTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('source_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('source_type')->nullable();
            $table->decimal('rate', 4, 4);//0.013
            $table->string('bank')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('dest_url')->nullable();
            $table->timestamps();
        });

        $sql = "ALTER TABLE source_types ALTER COLUMN dest_url NVARCHAR(MAX)";
        DB::statement($sql);

        $attributes['source_type']  = 'unionpay';//alipay //wechat
        $attributes['rate']         = 0.02;
        $attributes['bank']         = 'kbank';
        $attributes['name']         = 'Union Pay';
        $attributes['description']  = 'Union Pay by Kbank';
        SourceType::create( $attributes );

        $attributes['source_type']  = 'alipay'; //alipay //wechat
        $attributes['rate']         = 0.02;
        $attributes['bank']         = 'kbank';
        $attributes['name']         = 'AliPay';
        $attributes['description']  = 'AliPay by Kbank';
        SourceType::create( $attributes );

        $attributes['source_type']  = 'wechat'; //alipay //wechat
        $attributes['rate']         = 0.02;
        $attributes['bank']         = 'kbank';
        $attributes['name']         = 'WeChat Pay';
        $attributes['description']  = 'WeChat Pay by Kbank';
        SourceType::create( $attributes );

        $attributes['source_type']  = 'card'; //alipay //wechat
        $attributes['rate']         = 0.013;
        $attributes['bank']         = 'tbank';
        $attributes['name']         = 'Visa/Master Card';
        $attributes['description']  = 'Visa/Master Card by Tbank';
        SourceType::create( $attributes );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('source_types');
    }
}
