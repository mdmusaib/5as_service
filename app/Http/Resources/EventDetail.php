<?php

namespace App\Http\Resources;
use App\EventMaster;
use App\EventDetails;
use App\ProjectService;
use App\Http\Resources\ProjectService as ProjectServiceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EventDetail extends JsonResource
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
            'customer_id'=>$this->customer_id,
            'event'=>EventMaster::where('id','=',$this->event_id)->first(),
            'event_id'=>$this->event_id,
            'project_id'=>$this->project_id,
            "name"=> $this->name,
            "bride_name"=> $this->bride_name,
            "groom_name"=> $this->groom_name,
            "event_start_datetime"=> $this->event_start_datetime,
            "event_end_datetime"=> $this->event_end_datetime,
            "type_of_wedding"=> $this->type_of_wedding,
            "venue"=> $this->venue,
            "location"=> $this->location,
            "number_of_people"=> $this->number_of_people,
            "other_details"=> $this->other_details,
            "services"=>ProjectServiceResource::collection(ProjectService::where('event_id',$this->id)->get())
        ];
    }
}
