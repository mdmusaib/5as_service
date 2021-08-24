<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = [
        'base_price','adjustment','tax','discount','total_price',
    ];
    protected $hidden = [
        'created_at', 'updated_at',
    ];
}
