<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikeableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likeable',function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id');
            //now here we declare this becuse we can make it possible to use this with any
            //model
            $table->integer('likeable_id');
            //also we set type to use it with any other things like Photo
            $table->string('likeable_type');
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
        Schema::drop('likeable');
    }
}
