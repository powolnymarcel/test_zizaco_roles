<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TaggableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Des tags qui permettent de tagger n'importe quoi

        Schema::create('taggables', function (Blueprint $table) {
            //L'id
            $table->integer('tag_id')->unsigned();
            //L'id de l'item taggé
            $table->integer('taggable_id');
            //La class de l'item, le model
            $table->string('taggable_type');

            $table->foreign('tag_id')->references('id')->on('tags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('taggables');
    }
}
