<?php

namespace App\Modules\Contacts\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactList extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contact_list_name',
        'contact_list_description'
    ];

    public function contacts() {
        return $this->hasMany(Contact::class);
    }

    public function properties() {
        return $this->hasMany(Property::class);
    }
}
