<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectService extends Model
{
    protected $fillable = [
        'project_id','service_id','event_id','unit','price','total_price'
    ];
}
