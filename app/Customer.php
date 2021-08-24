<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'project_id', 'name', 'sales_person', 'email', 'phone', 'whatsapp', 'facebook', 'instagram', 'source', 'shoot_details', 'address','bride_name','groom_name'
    ];
    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id','id');
    }
    public function events()
    {
        return $this->belongsTo('App\EventDetail', 'id');
    }
}
