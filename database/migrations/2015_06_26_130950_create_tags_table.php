<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        //singulier et ordre alphabétique
        Schema::create('movie_tag', function(Blueprint $table)
        {
            $table->integer('movie_id')->unsigned()->index();//unsigned pour chiffre valeur positive, index plus rapide pour chercher dans BD
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');

            $table->integer('tag_id')->unsigned()->index();
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tag_movie');
        Schema::drop('tags');
    }
}
