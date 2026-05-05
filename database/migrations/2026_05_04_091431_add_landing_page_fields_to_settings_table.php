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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('hero_title')->nullable();
            $table->text('hero_description')->nullable();
            $table->text('principal_message')->nullable();
            $table->string('helpdesk_time')->nullable();
            $table->string('email_panitia')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->json('agendas')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'hero_title',
                'hero_description',
                'principal_message',
                'helpdesk_time',
                'email_panitia',
                'phone',
                'address',
                'facebook',
                'instagram',
                'youtube',
                'agendas'
            ]);
        });
    }
};
