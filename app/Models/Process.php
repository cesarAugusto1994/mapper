<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    protected $fillable = ['name', 'department_id', 'frequency_id'];

    protected $dates = ['range_start', 'range_end'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function subprocesses()
    {
        return $this->hasMany(SubProcesses::class, 'process_id');
    }
}
