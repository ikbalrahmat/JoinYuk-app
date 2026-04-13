<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konsumsis', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat_nde');
            $table->string('unit_kerja');
            $table->year('tahun_anggaran_rapat');
            $table->string('agenda_rapat');
            $table->date('tanggal_rapat');
            $table->time('jam_rapat');
            $table->string('unggah_dokumen_nde')->nullable(); // Boleh kosong
            $table->json('menu_konsumsi'); // Menyimpan array menu, detail, dan jumlah
            $table->decimal('total_biaya', 15, 2)->nullable(); // Awalnya kosong, diisi oleh Yanum
            $table->string('distribusi_tujuan');
            $table->string('lokasi_unit_kerja');
            $table->text('catatan')->nullable();
            $table->string('tanda_tangan')->nullable(); // Nama file tanda tangan
            $table->string('status')->default('Menunggu'); // Menunggu, Disetujui, Selesai
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konsumsis');
    }
};
