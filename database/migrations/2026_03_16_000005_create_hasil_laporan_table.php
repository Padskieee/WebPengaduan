<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('hasil_laporan', function (Blueprint $table) {
        $table->id('id_hasil');
        $table->unsignedBigInteger('id_laporan');
        $table->unsignedBigInteger('id_admin');
        $table->string('judul_output', 200);
        $table->text('deskripsi_output');
        $table->dateTime('tanggal_publish')->nullable();
        $table->enum('status_publish', ['draft','publish'])->default('draft');
        $table->timestamp('created_at')->useCurrent();

        $table->foreign('id_laporan')->references('id_laporan')->on('laporan')->onDelete('cascade');
        $table->foreign('id_admin')->references('id_admin')->on('admin');
    });
}
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
