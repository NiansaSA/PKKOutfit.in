<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePembeli extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_pembeli', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_pembeli', 100);
            $table->string('alamat', 100);
            $table->string('telp', 100);
            $table->string('username', 100);
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
        Schema::dropIfExists('table_pembeli');
    }
}
