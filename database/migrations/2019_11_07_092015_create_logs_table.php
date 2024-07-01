<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
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
            Schema::create('logs', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('type')->nullable();
                $table->string('log')->nullable();
                $table->string('log2')->nullable();
                $table->timestamps();
            });

            $sql = "ALTER TABLE logs ALTER COLUMN log NVARCHAR(MAX)";
            DB::statement($sql);
            $sql = "ALTER TABLE logs ALTER COLUMN log2 NVARCHAR(MAX)";
            DB::statement($sql);
        }
        else
        {
            Schema::create('logs', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('type')->nullable();
                $table->text('log')->nullable();
                $table->text('log2')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
