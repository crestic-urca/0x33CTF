<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidatedChallTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validated_chall', function (Blueprint $table) {
            $table->timestamp('date_validated')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean('state')->unsigned();

            $table->integer('sujet_id')->unsigned();
            $table->foreign('sujet_id')
                ->references('id')
                ->on('sujet')
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
        Schema::dropIfExists('validated_chall');
    }
}
