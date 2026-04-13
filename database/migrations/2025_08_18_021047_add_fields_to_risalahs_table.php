<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('risalahs', function (Blueprint $table) {
            $table->foreignId('rapat_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('presence_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('agenda')->nullable();
            $table->date('tanggal')->nullable();
            $table->time('waktu_mulai')->nullable();
            $table->time('waktu_selesai')->nullable();
            $table->string('tempat')->nullable();
            $table->string('pimpinan')->nullable();
            $table->string('pencatat')->nullable();
            $table->enum('jenis_rapat', ['Entry Meeting', 'Expose Meeting', 'Exit Meeting', 'Lainnya'])->nullable();
            $table->longText('penjelasan')->nullable();
            $table->longText('kesimpulan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('risalahs', function (Blueprint $table) {
            $table->dropForeign(['rapat_id']);
            $table->dropForeign(['presence_id']);
            $table->dropColumn([
                'rapat_id','presence_id','agenda','tanggal','waktu_mulai','waktu_selesai',
                'tempat','pimpinan','pencatat','jenis_rapat','penjelasan','kesimpulan'
            ]);
        });
    }
};
