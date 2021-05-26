<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
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
            "type" => "notes",
            "id" => (string) $this->resource->getRouteKey(),
            "attributes" => [
                "title" => $this->resource->title,
                "content" => $this->resource->content,
                "created_at" => $this->resource->created_at
            ],
            "links" => [
                "self" => route( "api.v1.notes.show", $this->resource->getRouteKey() )
            ]
        ];
    }
}
