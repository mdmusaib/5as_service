<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeAvalability extends Model
{
    protected $fillable = [
        'employee_id','unavailable_date',
    ];
    protected $table = "employee_availability";
}
