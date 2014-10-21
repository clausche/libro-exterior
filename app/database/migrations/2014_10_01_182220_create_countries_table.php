<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration {

    public function up()
    {
        Schema::create('countries', function($table)
        {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('user_id')->unsigned()->nullable()->default(NULL);
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('countries', function($table)
        {
            $table->dropForeign('countries_user_id_foreign');
        });
        Schema::drop('countries');
    }

}
