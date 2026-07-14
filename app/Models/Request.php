<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    // 1. Deklarasikan propertinya tanpa mengisi nilai teks langsung
    protected $table;
    
    protected $primaryKey = 'id_request';
    
    protected $fillable = [
        'nama_mahasiswa', 'software', 'dosen_ta', 'no_hp', 'tanggal_mulai', 
        'perkiraan_selesai', 'foto_bukti', 'status', 'catatan', 
        'id_teknisi', 'nrp', 'id_laboratorium', 'id_komputer'
    ];

    // 2. Set nilai tabel secara dinamis di dalam constructor
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        // Mengambil nama database utama secara dinamis ('sistem_monitoring')
        $mainDb = config('database.connections.mysql.database');
        
        // Menghasilkan 'sistem_monitoring.request'
        $this->table = $mainDb . '.request';
    }

    public function teknisi(){
        return $this->belongsTo(Teknisi::class, 'id_teknisi', 'id_teknisi');
    }

    public function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class, 'nrp', 'nrp');
    }

    public function komputer(){
        return $this->belongsTo(Komputer::class, 'id_komputer', 'id_komputer');
    }

    public function laboratorium(){
        return $this->belongsTo(Laboratorium::class, 'id_laboratorium', 'id_laboratorium');
    }
}