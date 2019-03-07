<?php

namespace App\Models\Documents;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'documents_statuses';
    protected $fillable = ['name'];
}
