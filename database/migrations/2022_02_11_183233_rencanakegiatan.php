<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Rencanakegiatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rencanakegiatan', function (Blueprint $table) {
            $table->increments("id_rencana");
            $table->string("bulan_tahun");
            $table->string("jeniskegiatan");
            $table->String("tentang")->nullable();
            $table->String("personal");
            $table->String ("status");
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
        Schema::dropIfExists('rencanakegiatan');
    }
}
