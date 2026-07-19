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
        
        $mainDb = config('database.connections.mysql.database');
        
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

    // 3. SENSOR OTOMATIS (MODEL EVENTS) UNTUK JUMLAH KOMPUTER DI LAB
    protected static function booted()
    {
        // A. Saat Komputer BARU ditambahkan -> Tambah +1 ke Lab terkait
        static::created(function ($komputer) {
            $komputer->laboratorium()->increment('jumlah_komputer');
        });

        // B. Saat Komputer DIHAPUS -> Kurangi -1 dari Lab terkait
        static::deleted(function ($komputer) {
            $komputer->laboratorium()->decrement('jumlah_komputer');
        });

        // C. Saat Komputer DIPINDAH ke Lab lain -> Kurangi dari Lab lama, Tambah ke Lab baru
        static::updated(function ($komputer) {
            // Cek apakah data kolom 'id_laboratorium' benar-benar mengalami perubahan
            if ($komputer->wasChanged('id_laboratorium')) {
                
                // Ambil ID lab yang lama sebelum diganti
                $idLabLama = $komputer->getOriginal('id_laboratorium');
                
                // Kurangi -1 dari Lab yang lama (jika lab lamanya ditemukan)
                if ($idLabLama) {
                    Laboratorium::find($idLabLama)?->decrement('jumlah_komputer');
                }
                
                // Tambah +1 ke Lab yang baru
                $komputer->laboratorium()->increment('jumlah_komputer');
            }
        });
    }
}