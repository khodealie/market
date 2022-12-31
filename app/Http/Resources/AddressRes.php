<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressRes extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public static $wrap = null;

    public function toArray($request)
    {
        return [
            'id' => $this['id'],
            'isWorkplace' => $this['workplace'] ?? false,
            'address' => $this['address'],
            'longitude' => $this['longitude'],
            'latitude' => $this['latitude']
        ];
    }
}
