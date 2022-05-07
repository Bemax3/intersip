<?php

namespace App\Modules\Contacts\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "property_name",
        "property_description",
        "property_showing",
        "contact_list_id",
    ];

    public function contacts() {
        return $this->belongsToMany(Contact::class,'contact_properties','property_id','contact_id');
    }
}
