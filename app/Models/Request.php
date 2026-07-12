<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = 'request';
    
    protected $primaryKey = 'id_request';
    protected $fillable = ['nama_mahasiswa', 'software', 'dosen_ta', 'software', 'no_hp', 'tanggal_mulai', 'perkiraan_selesai', 'foto_bukti', 'status', 'catatan', 'id_teknisi', 'nrp', 'id_laboratorium', 'id_komputer'];

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