<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'nilai_ujian' => 'array',
    ];

    public function accessLogs()
    {
        return $this->hasMany(AccessLog::class);
    }
}
