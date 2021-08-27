<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskTracker extends Model
{
    protected $fillable = [
        'employee_id','task_id','start_time','end_time','is_started'
    ];
    protected $table = "task_time_tracker";
}
