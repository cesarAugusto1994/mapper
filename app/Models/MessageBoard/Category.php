<?php

namespace App\Models\MessageBoard;

use Illuminate\Database\Eloquent\Model;
use Emadadly\LaravelUuid\Uuids;
use Spatie\Activitylog\Traits\LogsActivity;

class Category extends Model
{
    use Uuids;
    use LogsActivity;

    protected $table = 'meassage_board_categories';

    protected $fillable = ['category_id', 'board_id'];
    protected static $logAttributes = ['category_id', 'board_id'];
}
