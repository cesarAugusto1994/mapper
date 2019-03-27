<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class People extends Model
{
    use Uuids;
    use LogsActivity;

    protected $fillable = ['name', 'department_id', 'occupation_id', 'cpf'];

    protected static $logAttributes = ['name', 'department_id', 'occupation_id', 'cpf'];

    public function department()
    {
        return $this->belongsTo('App\Models\Department');
    }

    public function occupation()
    {
        return $this->belongsTo('App\Models\Department\Occupation');
    }
}
