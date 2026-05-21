<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komputer extends Model
{
    use HasFactory;

    protected $table = 'komputer';
    protected $primaryKey = 'id_komputer';
    protected $fillable = ['nama_komputer', 'id_laboratorium'];

}