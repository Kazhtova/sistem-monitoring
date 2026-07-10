<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teknisi extends Authenticatable
{
    use HasRoles, HasFactory;

    protected $table = 'teknisi';
    protected $primaryKey = 'id_teknisi';
    protected $fillable = ['nama_teknisi'];

    public function request(){
        return $this->hasMany(Request::class, 'id_teknisi', 'id_teknisi');
    }
}