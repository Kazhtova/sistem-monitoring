<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Laboratorium extends Model
{
    use HasFactory;

    protected $table;

    protected $primaryKey = 'id_laboratorium';
    
    protected $fillable = ['nama_lab', 'jumlah_komputer', 'id_teknisi'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        $mainDb = config('database.connections.mysql.database'); // Mengambil 'sistem_monitoring'
        
        $this->table = $mainDb . '.laboratorium'; 
    }

    public function teknisi(): BelongsTo
    {
        return $this->belongsTo(Teknisi::class, 'id_teknisi');
    }
}