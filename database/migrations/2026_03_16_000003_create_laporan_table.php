<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('laporan', function (Blueprint $table) {
        $table->id('id_laporan');
        $table->unsignedBigInteger('id_user');
        $table->unsignedBigInteger('id_admin')->nullable();
        $table->unsignedBigInteger('id_kategori');
        $table->string('judul_laporan', 200);
        $table->text('isi_laporan');
        $table->date('tanggal_kejadian')->nullable();
        $table->string('lokasi_kejadian', 255)->nullable();
        $table->tinyInteger('anonim')->default(0);
        $table->enum('status', ['menunggu','diverifikasi','diproses','selesai','ditolak'])->default('menunggu');
        $table->timestamps();

        $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        $table->foreign('id_admin')->references('id_admin')->on('admin');
        $table->foreign('id_kategori')->references('id_kategori')->on('kategori_laporan');
    });
}
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
