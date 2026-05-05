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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('school_name')->nullable();
            $table->string('principal_name')->nullable();
            $table->string('principal_nip')->nullable();
            $table->string('kop_surat')->nullable();
            $table->string('signature')->nullable();
            $table->string('stamp')->nullable();
            $table->text('skl_template')->nullable();
            $table->dateTime('announcement_date')->nullable();
            $table->boolean('announcement_status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
