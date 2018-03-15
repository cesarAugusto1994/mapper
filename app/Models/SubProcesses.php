<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubProcesses extends Model
{
    protected $fillable = ['name', 'process_id'];

    public function process()
    {
        return $this->belongsTo(Process::class, 'process_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'sub_process_id');
    }
}
