<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Komputer extends Model
{
    use HasFactory;

    // 1. Deklarasikan properti tanpa nilai teks langsung
    protected $table;
    protected $primaryKey = 'id_komputer';
    protected $fillable = ['nama_komputer', 'id_laboratorium'];

    // 2. Set nilai tabel secara dinamis ke database utama
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        $mainDb = config('database.connections.mysql.database'); // Mengambil 'sistem_monitoring'
        
        // Menghasilkan 'sistem_monitoring.komputer'
        $this->table = $mainDb . '.komputer'; 
    }

    public function laboratorium(): BelongsTo{
        return $this->belongsTo(Laboratorium::class, 'id_laboratorium');
    }

    public function requests(): HasMany
    {
        return $this->hasMany(Request::class, 'id_komputer');
    }
}