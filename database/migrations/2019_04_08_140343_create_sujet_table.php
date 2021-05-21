<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSujetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sujet', function (Blueprint $table) {
            $table->increments('id');
            $table->text('enonce');
            $table->string('titre');
            $table->string('flag');

            $table->string('file_name')->nullable();

            $table->boolean('hide')->default(true);
            $table->integer('nb_points')->unsigned();
            $table->integer('nb_try')->unsigned()->default(0);

            $table->integer('categorie_id')->unsigned();
            $table->foreign('categorie_id')
                ->references('id')
                ->on('categorie')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
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
        Schema::dropIfExists('sujet');
    }
}
