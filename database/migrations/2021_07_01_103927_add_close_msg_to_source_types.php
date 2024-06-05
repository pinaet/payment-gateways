<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCloseMsgToSourceTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('source_types', function (Blueprint $table) {
            $table->tinyInteger('close_status')->nullable();
            $table->string('close_message')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('source_types', function (Blueprint $table) {
            $table->dropColumn('close_status', 'close_message');
        });
    }
}
