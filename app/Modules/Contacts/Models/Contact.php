<?php

namespace App\Modules\Contacts\Models;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory;
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contact_list_id',
        'contact_phone_number',
        'country_id',
        'created_by'
    ];

    public function list() {
        return $this->belongsTo(ContactList::class);
    }

    public function properties() {
        return $this->belongsToMany(Property::class,'contact_properties','contact_id','property_id')->withPivot('value');
    }

    public function groups() {
        return $this->belongsToMany(Group::class,'contact_groups','contact_id','group_id');
    }

    public function person() {
        return $this->belongsToMany(Person::class);
    }

    public function country() {
        return $this->belongsTo(Country::class);
    }

}
