<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('lampiran_hasil', function (Blueprint $table) {
        $table->id('id_lampiran_hasil');
        $table->unsignedBigInteger('id_hasil');
        $table->enum('jenis_lampiran', ['sebelum','sesudah','lainnya']);
        $table->string('file_path', 255);
        $table->enum('tipe_file', ['foto','video','dokumen']);
        $table->timestamp('created_at')->useCurrent();

        $table->foreign('id_hasil')->references('id_hasil')->on('hasil_laporan')->onDelete('cascade');
    });
}
    public function down(): void
    {
        Schema::dropIfExists('lampiran_hasil');
    }
};
