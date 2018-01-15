<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Task;

class TaskPause extends Model
{
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
