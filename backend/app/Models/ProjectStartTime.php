<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectStartTime extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'project_start_times';

    protected $hidden = ['id'];
    protected $fillable = ['key', 'text'];
}
