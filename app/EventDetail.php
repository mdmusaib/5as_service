<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventDetail extends Model
{
    protected $fillable = [
        'customer_id','name','type_of_wedding','venue','location',
        'event_id','project_id','event_start_datetime','event_end_datetime','number_of_people','other_details'
    ];
}
