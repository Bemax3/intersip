<?php

namespace App\Modules\Contacts\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Contacts\Http\Resources\PropertyResource;
use App\Modules\Contacts\Models\Property;

class PropertiesController extends Controller
{
    public function getPropsOfUser($id) {
        $list = User::findOrFail($id)->lists()->first();
        return PropertyResource::collection(Property::query()->where('contact_list_id',$list->id)->get());
    }
}
