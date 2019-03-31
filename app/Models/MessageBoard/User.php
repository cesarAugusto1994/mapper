<?php

namespace App\Models\MessageBoard;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'meassage_board_users';

    protected $fillable = ['user_id', 'board_id', 'status'];
    protected static $logAttributes = ['user_id', 'board_id', 'status'];
}
