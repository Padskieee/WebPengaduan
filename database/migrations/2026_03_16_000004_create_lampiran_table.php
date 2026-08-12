<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('lampiran', function (Blueprint $table) {
        $table->id('id_lampiran');
        $table->unsignedBigInteger('id_laporan');
        $table->string('file_path', 255);
        $table->enum('tipe_file', ['foto','video','dokumen']);
        $table->timestamp('created_at')->useCurrent();

        $table->foreign('id_laporan')->references('id_laporan')->on('laporan')->onDelete('cascade');
    });
}
    public function down(): void
    {
        Schema::dropIfExists('lampiran');
    }
};
