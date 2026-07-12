<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Mahasiswa extends Authenticatable
{
    use HasRoles, HasFactory;

    protected $table = 'mahasiswa';

    protected $primaryKey = 'nrp';

    protected $fillable = ['nrp', 'nama_mahasiswa', 'password','fcm_token'];

    public function requests(){
        return $this->hasMany(Request::class, 'nrp', 'nrp');
    }
    
}