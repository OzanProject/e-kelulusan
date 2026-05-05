<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    /**
     * Helper: ambil semua mapel aktif, diurutkan.
     */
    public static function aktif()
    {
        return static::where('aktif', true)->orderBy('urutan')->orderBy('id')->get();
    }
}
