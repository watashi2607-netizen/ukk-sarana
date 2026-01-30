<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengaduan extends Model
{
    use HasFactory;
    protected $fillable = ['siswa_id', 'kategori_id', 'deskripsi', 'status', 'tanggal_pengaduan'];

    protected $casts = [
        'tanggal_pengaduan' => 'date',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
