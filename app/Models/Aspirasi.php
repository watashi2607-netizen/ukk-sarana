<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aspirasi extends Model
{
    use HasFactory;

    protected $table = 'aspirasis';
    protected $primaryKey = 'id_aspirasi';
    protected $fillable = ['status', 'id_kategori', 'feedback', 'id_pelaporan'];

    protected $casts = [
        'status' => 'string',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function inputAspirasi()
    {
        return $this->belongsTo(InputAspirasi::class, 'id_pelaporan', 'id_pelaporan');
    }
}
