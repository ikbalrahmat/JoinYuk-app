<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agenda_rapats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rapat_id')->constrained()->onDelete('cascade');
            $table->string('jam');
            $table->string('agenda');
            $table->string('pic');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agenda_rapats');
    }
};
