<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Client extends Model
{
    use Uuids;
    use LogsActivity;

    protected $fillable = ['name', 'email', 'phone'];

    protected static $logAttributes = ['name', 'email', 'phone'];

    public function documents()
    {
        return $this->hasMany('App\Models\Documents', 'client_id');
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\Client\Address', 'client_id');
    }
}
