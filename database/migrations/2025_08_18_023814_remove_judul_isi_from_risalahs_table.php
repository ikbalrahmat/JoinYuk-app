<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('risalahs', function (Blueprint $table) {
            $table->dropColumn(['judul', 'isi']);
        });
    }

    public function down(): void
    {
        Schema::table('risalahs', function (Blueprint $table) {
            $table->string('judul')->nullable();
            $table->text('isi')->nullable();
        });
    }
};
