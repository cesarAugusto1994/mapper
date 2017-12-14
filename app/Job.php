<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    const STATUS_PENDENTE = 1;

    protected $fillable = [
        'description', 'process_id', 'user_id',
        'frequency', 'time', 'method',
        'indicator', 'client_id', 'vendor_id',
        'severity', 'urgency', 'trend',
        'status_id', 'created_by', 'active'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function client()
    {
        return $this->belongsTo(Department::class, 'client_id');
    }

    public function status()
    {
        return $this->belongsTo(jobStatus::class, 'status_id');
    }

    public function sponsor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
