<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Mahasiswa extends Authenticatable
{
    use HasRoles, HasFactory;

protected $connection = 'mysql_luar';

    protected $table = 'mhs';

    protected $primaryKey = 'nrp';

    protected $fillable = ['nrp', 'nama', 'password', 'fcm_token'];

    public function getRememberTokenName()
    {
        return null;
    }

    /**
     * Mencegah error saat Laravel mencoba set nilai token di memori runtime
     */
    public function setRememberToken($value)
    {
        // Dikosongkan saja agar tidak melakukan apa-apa
    }

    public function requests(){
        return $this->hasMany(Request::class, 'nrp', 'nrp');
    }
    
}