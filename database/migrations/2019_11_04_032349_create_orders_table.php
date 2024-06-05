<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('endpoint_id')->nullable();
            $table->decimal('amount', 10, 2)->default(0.0);
            $table->decimal('total_amount', 10, 2)->default(0.0);
            $table->string('currency', 3)->nullable();
            $table->string('description')->nullable();
            $table->string('reference_order')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->bigInteger('source_type_id')->nullable();
            $table->string('source_type')->nullable();
            $table->string('source')->nullable();//pan - additional_data
            $table->string('status',1)->nullable()->default('p'); //p=pending; f=failed; c=completed
            $table->string('ref')->nullable();
            $table->string('ref2')->nullable();
            $table->string('ref3')->nullable();
            $table->bigInteger('transaction_id')->nullable();
            $table->tinyInteger('email_sent')->nullable()->default(0);
            $table->timestamps();
        });
        
        $sql = "ALTER TABLE orders ALTER COLUMN source NVARCHAR(MAX)";
        DB::statement($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
