<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CalendarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,           
            'location' => $this->location,
            'start' => Carbon::parse($this->start_date)->format('Y-m-d'),
            // 'start_time' => Carbon::parse($this->start_time)->format('H:i'),
            'end' => Carbon::parse($this->end_date)->format('Y-m-d'),
            // 'end_time' => Carbon::parse($this->end_time)->format('H:i'),
            
        ];
    }
}