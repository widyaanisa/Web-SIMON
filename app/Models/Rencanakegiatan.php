<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rencanakegiatan extends Model
{
    use HasFactory;

    protected $table = 'rencanakegiatan';
    protected $primaryKey = 'id_rencana';

    protected $fillable = [
        'bulan_tahun', 'jeniskegiatan', 'tentang', 'personal','status'
    ];

    public function fileRencanaKegiatan()
    {
        return $this->hasMany(FileRencanaKegiatan::class, 'id_rencana_kegiatan', 'id_rencana');
    }

    // public function setFile($tentang)
    // {
    //     $file_temp = $tentang;
    //     $filename =  time().'-'.$file_temp->getClientOriginalName();
    //     if (!file_exists(public_path('file'))) {
    //         mkdir(public_path('file'), 0777, true);
    //     }
    //     $destination_path = public_path('file/');
    //     $file_temp->move($destination_path, $filename);

    //     return $filename;
    // }

    public function removeFile($filename)
    {
        if (file_exists(public_path('file/' . $filename))) {
            unlink(public_path('file/' . $filename));
        }
    }
}
