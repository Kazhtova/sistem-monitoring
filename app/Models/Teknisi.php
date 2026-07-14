<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teknisi extends Authenticatable
{
    use HasRoles, HasFactory;

    // 1. Deklarasikan properti tanpa nilai teks langsung
    protected $table;
    protected $primaryKey = 'id_teknisi';
    protected $fillable = ['nama_teknisi'];

    // 2. Set nilai tabel secara dinamis ke database utama
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        $mainDb = config('database.connections.mysql.database'); // Mengambil 'sistem_monitoring'
        $this->table = $mainDb . '.teknisi'; // Menghasilkan 'sistem_monitoring.teknisi'
    }

    public function request(){
        return $this->hasMany(Request::class, 'id_teknisi', 'id_teknisi');
    }
}