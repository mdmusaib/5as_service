<?php

namespace App\Http\Resources;
use App\User;
use App\Task;
use App\ServicesMaster;
use App\EventMaster;
use stdClass;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskTracker extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $taskDetails=Task::where('id','=',$this->task_id)->first();
        $finalResponseObj=new stdClass();
        if($taskDetails){
            $finalResponseObj->service=ServicesMaster::where('id', '=', $taskDetails->service_id)->first();
            $finalResponseObj->event=EventMaster::where('id', '=', $taskDetails->event_id)->first();
        }
        
        return [
            'id'=>$this->id,
            "employee"=>User::where('id','=',$this->employee_id)->first(),
            "task"=>$finalResponseObj?$finalResponseObj:[],
            "start_time"=>$this->start_time,
            "end_time"=>$this->end_time,
        ];
    }
}
