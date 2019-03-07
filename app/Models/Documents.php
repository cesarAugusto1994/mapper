<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Documents extends Model
{
    use Uuids;
    use LogsActivity;

    protected $fillable = ['description', 'client_id', 'created_by', 'status_id'];

    protected static $logAttributes = ['description', 'client_id', 'created_by'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}
