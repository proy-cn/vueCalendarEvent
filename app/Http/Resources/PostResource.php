<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'user' => $this->user->name,
            'body' => $this->description,
            'imagePath' => $this->cover_image,
            'category_id' => $this->category_id,
            'location' => $this->location,
            'start_date' => Carbon::parse($this->start_date)->format('Y-m-d'),
            'start_time' => Carbon::parse($this->start_time)->format('H:i'),
            'end_date' => Carbon::parse($this->end_date)->format('Y-m-d'),
            'end_time' => Carbon::parse($this->end_time)->format('H:i'),
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}