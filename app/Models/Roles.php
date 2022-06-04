<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = 'roles';
    protected $fillable = [
    	'name', 'guard_name'
    ];

    public function user(){
    	$this->hasOne('App\User', 'role_id');
    }
    use HasFactory;
}
