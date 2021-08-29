<?php

namespace App\Http\Resources;
use App\Task;
use App\User;
use App\ServicesMaster;
use App\EventMaster;
use stdClass;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskOfEmployee extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $taskDetails=Task::where('id','=',$this->id)->first();
        $finalResponseObj=new stdClass();
        if($taskDetails){
            $finalResponseObj->service=ServicesMaster::where('id', '=', $taskDetails->service_id)->first();
            $finalResponseObj->event=EventMaster::where('id', '=', $taskDetails->event_id)->first();
        }
        return [
            'id'=>$this->id,
            "employee"=>User::where('id','=',$this->employee_id)->first(),
            "service"=>$finalResponseObj?$finalResponseObj->service:[],
            "event"=>$finalResponseObj?$finalResponseObj->event:[],
            "available_date"=>$this->available_date,
        ];
    }
}
