<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class DeliveryOrder extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'delivery_order';
}
