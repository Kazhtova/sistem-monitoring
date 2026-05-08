<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = 'request';
    
    protected $primaryKey = 'id_request';
    protected $fillable = ['software', 'dosen_ta', 'software', 'no_hp', 'tanggal_mulai', 'perkiraan_selesai', 'foto_bukti', 'status', 'catatan', 'id_teknisi', 'id_mahasiswa', 'id_komputer'];
}