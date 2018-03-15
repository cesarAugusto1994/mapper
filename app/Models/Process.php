<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    protected $fillable = ['name', 'department_id', 'frequency_id'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
