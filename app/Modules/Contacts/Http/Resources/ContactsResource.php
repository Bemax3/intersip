<?php

namespace App\Modules\Contacts\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'number' => $this->contact_phone_number,
            'country' => new CountriesResource($this->country),
            $this->mergeWhen($request->properties,[
                'properties' => PropertiesResource::collection($this->properties)
            ]),
        ];
    }
}
