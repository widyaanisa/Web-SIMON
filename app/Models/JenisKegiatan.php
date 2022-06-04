<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKegiatan extends Model
{
    use HasFactory;

    protected $table = 'jeniskegiatan';
    protected $primaryKey = 'id_jeniskegiatan';

    protected $fillable = [
        'namakegiatan'
    ];
    
    public function user(){
        return $this->hasMany('App\Models\JenisKegiatan');
    }
}
