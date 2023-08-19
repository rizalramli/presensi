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
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade');
            $table->date('tanggal');
            $table->time('jam_masuk');
            $table->decimal('latitude_masuk', 10, 7);
            $table->decimal('longitude_masuk', 10, 7);
            $table->text('foto_masuk');
            $table->integer('status_lokasi_masuk')->comment('0=diluar radius,1=didalam radius');
            $table->time('jam_pulang')->nullable();
            $table->decimal('latitude_pulang', 10, 7)->nullable();
            $table->decimal('longitude_pulang', 10, 7)->nullable();
            $table->text('foto_pulang')->nullable();
            $table->integer('status_lokasi_pulang')->nullable()->comment('0=diluar radius,1=didalam radius');
            $table->integer('status_absensi')->comment('1=tepat waktu, 2=terlambat dengan toleransi, 3=terlambat tanpa toleransi');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
