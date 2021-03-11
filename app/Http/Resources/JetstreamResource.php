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
            'attributes' => parent::toArray($request),
            'permissions' => [
                'canView' => true,
                'canUpdate' => true,
                'canDelete' => true,
            ]
        ];
    }
}
