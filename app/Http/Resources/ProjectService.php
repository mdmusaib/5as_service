<?php

namespace App\Http\Resources;

use App\ServicesMaster;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectService extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $name=ServicesMaster::where('id', '=', $this->service_id)->first(['name']);
        
        return [
            'id'=>$this->id,
            "project_id"=>$this->project_id,
            "name"=>$name->name,
            "service_id"=>$this->service_id,
            "service"=>ServicesMaster::where('id', '=', $this->service_id)->first(),
            "unit"=>$this->unit,
            "price"=>$this->price,
            "total_price"=>$this->total_price,
        ];
    }
}
