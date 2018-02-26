<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mapper extends Model
{
    public function tasks()
    {
        return $this->hasMany(Task::class, 'mapper_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
