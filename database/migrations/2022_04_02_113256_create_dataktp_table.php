<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataktpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dataktp', function (Blueprint $table) {
            $table->id();
            $table->string('nama',50);
            $table->string('tempat_lahir',50);
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('foto');
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
        Schema::dropIfExists('dataktp');
    }
}
