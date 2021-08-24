<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceMaster extends JsonResource
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
            'service_id'=>$this->id,
            "name"=>$this->name,
            "base_unit_price"=>$this->base_unit_price,
            "tax"=>$this->tax,
            "description"=>$this->description,
            'isDeliverable' => $this->is_deliverable
        ];
    }
}
