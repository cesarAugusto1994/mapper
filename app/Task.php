<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    const STATUS_PENDENTE = 1;
    const STATUS_EM_ANDAMENTO = 2;
    const STATUS_FINALIZADO = 3;
    const STATUS_CANCELADO = 4;

    protected $fillable = [
        'description', 'process_id', 'user_id',
        'frequency', 'time', 'method',
        'indicator', 'client_id', 'vendor_id',
        'severity', 'urgency', 'trend',
        'status_id', 'created_by', 'active', 'mapper_id'
    ];

    protected $dates = ['begin', 'end'];

    public function process()
    {
        return $this->belongsTo(Process::class, 'process_id');
    }

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
        return $this->belongsTo(TaskStatus::class, 'status_id');
    }

    public function sponsor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mapper()
    {
        return $this->belongsTo(Mapper::class, 'mapper_id');
    }


}
