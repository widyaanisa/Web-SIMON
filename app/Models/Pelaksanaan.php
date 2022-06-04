<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelaksanaan extends Model
{
    use HasFactory;

    protected $table = 'pelaksanaan';

    protected $fillable = [
        'bulan_tahun',
        'jenis_kegiatan',
        'no_sprint',
        'waktu',
        'personal',
        'outcome',
        'status_id'
    ];

    public function fileLaporan()
    {
        return $this->hasMany(FileLaporan::class, 'id_pelaksanaan', 'id');
    }

    public function filePelaksanaan()
    {
        return $this->hasMany(FilePelaksanaan::class, 'id_pelaksanaan', 'id');
    }

    public function filePerwaktu()
    {
        return $this->hasMany(FilePerwaktu::class, 'id_pelaksanaan', 'id');
    }
}
