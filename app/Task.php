<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'employee_id','service_id','event_id','project_id','available_date'
    ];
    protected $table = "task";
}
