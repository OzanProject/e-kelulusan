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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique()->comment('Singkatan, mis: MTK, PAI');
            $table->string('nama')->comment('Nama lengkap, mis: Matematika');
            $table->unsignedSmallInteger('urutan')->default(0)->comment('Urutan kolom di tabel');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
