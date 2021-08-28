<?php

namespace App\Http\Resources;
use App\User;
use App\Task;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskTimer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
         return [
            'id'=>$this->id,
            "employee"=>User::where('id','=',$this->employee_id)->first(),
            "start_time"=>$this->start_time,
            "end_time"=>$this->end_time,
            "status"=>$this->is_started,
        ];
    }
}
