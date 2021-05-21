<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitationPlayerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitation_player', function (Blueprint $table) {

            $table->timestamp('date_invitation')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('state')->unsigned()->default(0);

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');

            $table->integer('team_id')->unsigned();
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
        Schema::dropIfExists('invitation_player');
    }
}
