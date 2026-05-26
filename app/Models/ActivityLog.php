<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';
    protected $primaryKey = 'id_log';

    protected $fillable = [
        'causer_type', 'causer_id', 'causer_name',
        'action', 'subject_type', 'subject_id',
        'description', 'properties', 'ip_address', 'user_agent'
    ];
    
    protected $casts = [
        'properties'    => 'array'
    ];

    public function causer(){
        return $this->morphTo();
    }

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }
}