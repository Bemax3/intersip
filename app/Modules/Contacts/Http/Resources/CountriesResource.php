<?php

namespace App\Modules\Contacts\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CountriesResource extends JsonResource
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
            'name' => $this->settings_country_short_name,
            'calling_code' => $this->settings_country_calling_code,
            'iso2' => $this->settings_country_iso2
        ];
    }
}
