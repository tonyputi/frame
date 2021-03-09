<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JetstreamResource extends JsonResource
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
            'fields' => parent::toArray($request),
            'permissions' => [
                'canSee' => true,
                'canUpdate' => true,
                'canDelete' => true,
            ]
        ];
    }
}
