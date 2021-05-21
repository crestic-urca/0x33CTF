<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJoinDemandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('join_demand', function (Blueprint $table) {
            $table->timestamp('date_join_demand')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('state')->unsigned()->default(0);

            $table->integer('user_id')->unsigned()->onDelete('set null');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');

            $table->integer('team_id')->unsigned()->onDelete('set null');
            $table->foreign('team_id')
                ->references('id')
                ->on('team')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('join_demand');
    }
}
