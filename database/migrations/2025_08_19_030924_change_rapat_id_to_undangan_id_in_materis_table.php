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
        Schema::table('materis', function (Blueprint $table) {
            // Hapus foreign key dan kolom 'rapat_id'
            $table->dropForeign(['rapat_id']);
            $table->dropColumn('rapat_id');

            // Tambahkan kolom 'undangan_id' yang baru
            $table->foreignId('undangan_id')->after('id')->constrained('undangan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materis', function (Blueprint $table) {
            // Hapus kolom 'undangan_id' jika roll back
            $table->dropForeign(['undangan_id']);
            $table->dropColumn('undangan_id');

            // Tambahkan kembali kolom 'rapat_id'
            $table->foreignId('rapat_id')->after('id')->constrained('rapats');
        });
    }
};
