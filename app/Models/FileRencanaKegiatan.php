<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileRencanaKegiatan extends Model
{
    use HasFactory;

    protected $table = "file_rencana_kegiatan";

    protected $fillable = [
        'id_rencana_kegiatan', 'nama_file'
    ];

    public function rencanaKegiatan() {
        return $this->belongsTo(Rencanakegiatan::class, 'id_rencana_kegiatan', 'id_rencana');
    }
}
