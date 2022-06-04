<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilePerwaktu extends Model
{
    use HasFactory;

    protected $table = 'file_perwaktu';
    protected $fillable = ['id_pelaksanaan', 'nama_file'];

    public function pelaksanaan()
    {
        return $this->belongsTo(Pelaksanaan::class, 'id_pelaksanaan', 'id');
    }
}
