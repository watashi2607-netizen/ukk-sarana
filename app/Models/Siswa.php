<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';
    protected $fillable = ['nis', 'nama', 'kelas', 'jurusan'];

    public function inputAspirasis()
    {
        return $this->hasMany(InputAspirasi::class, 'nis', 'nis');
    }
}
