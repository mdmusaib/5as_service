<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\EventDetail;

class Customer extends JsonResource
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
            'id'=>$this->project->id,
            'lead_date'=>$this->created_at,
            'name'=>$this->name,
            'contact_number'=>$this->phone,
            'bride_name'=>$this->bride_name,
            'groom_name'=>$this->groom_name,
            'events'=>EventDetail::where('customer_id', $this->id)->get(),
            'status'=>$this->project->current_status,
            'follow_up_date'=>$this->project->next_follow_up
        ];
    }
}
