<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('log_status', function (Blueprint $table) {
        $table->id('id_log');
        $table->unsignedBigInteger('id_laporan');
        $table->string('status', 50);
        $table->text('keterangan')->nullable();
        $table->string('updated_by', 50)->nullable();
        $table->timestamp('tanggal_update')->useCurrent();

        $table->foreign('id_laporan')->references('id_laporan')->on('laporan')->onDelete('cascade');
    });
}
    public function down(): void
    {
        Schema::dropIfExists('log_status');
    }
};
