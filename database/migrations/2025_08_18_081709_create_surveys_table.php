<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->date('deadline')->nullable();
            $table->enum('status', ['Draft', 'Aktif', 'Selesai'])->default('Draft');
            $table->unsignedBigInteger('user_id'); // siapa yg buat
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surveys');
    }
};
