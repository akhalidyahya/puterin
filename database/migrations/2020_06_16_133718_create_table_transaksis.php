<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTransaksis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('no_pengirim',15);
            $table->string('no_tujuan',15);
            $table->string('fintech_pengirim',15);
            $table->string('fintech_tujuan',15);
            $table->string('nominal',15);
            $table->string('bukti',50)->nullable();
            $table->enum('status',[0,1,2,3,4,5])->default(0); //0=menunggu bukti 1=bukti valid 2=diproses 3=selesai 4=dibatalkan 5=bukti tidak valid
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
        Schema::dropIfExists('table_transaksis');
    }
}
