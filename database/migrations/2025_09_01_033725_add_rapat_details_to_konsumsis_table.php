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
        Schema::table('konsumsis', function (Blueprint $table) {
            $table->string('nama_pemesan')->nullable()->after('nomor_surat_nde');
            $table->integer('jumlah_peserta')->nullable()->after('nama_pemesan');
            $table->string('layout_ruangan')->nullable()->after('jumlah_peserta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konsumsis', function (Blueprint $table) {
            $table->dropColumn(['nama_pemesan', 'jumlah_peserta', 'layout_ruangan']);
        });
    }
};
