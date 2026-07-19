<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $table;
    protected $primaryKey = 'id_dosen';
    protected $fillable = ['nama_dosen'];
    
    public $timestamps = false;
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        $mainDb = config('database.connections.mysql.database'); 
        
        $this->table = $mainDb . '.dosen'; 
    }
}