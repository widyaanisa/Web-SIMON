<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Datamainadmin extends Migration
{
    public function up()
    {
        Schema::create('mainadmin', function (Blueprint $table) {
            $table->increments("id_mainadmin");
            $table->string("nama");
            $table->string("username");
            $table->String("password");
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
        Schema::dropIfExists('mainadmin');
    }
}
