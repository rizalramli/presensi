<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cuti', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_jenis_cuti');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_user_konfirmasi')->nullable();
            $table->foreign('id_jenis_cuti')->references('id')->on('jenis_cuti')->onUpdate('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('id_user_konfirmasi')->references('id')->on('users')->onUpdate('cascade');
            $table->date('tanggal_pengajuan');
            $table->date('dari_tanggal');
            $table->date('sampai_tanggal');
            $table->integer('lama_hari');
            $table->text('bukti_foto');
            $table->text('keterangan');
            $table->date('tanggal_konfirmasi')->nullable();
            $table->text('alasan_penolakan')->nullable();
            $table->integer('status')->comment('0=menunggu persetujuan, 1=disetujui, 2=ditolak');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuti');
    }
};
