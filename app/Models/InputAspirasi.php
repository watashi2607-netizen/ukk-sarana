<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InputAspirasi extends Model
{
    use HasFactory;

    protected $table = 'input_aspirasis';
    protected $primaryKey = 'id_pelaporan';
    protected $fillable = ['nis', 'id_kategori', 'lokasi', 'keterangan', 'gambar'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis', 'nis');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function aspirasi()
    {
        return $this->hasOne(Aspirasi::class, 'id_pelaporan', 'id_pelaporan');
    }
}
