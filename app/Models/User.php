<?php

namespace App\Models;


use App\Modules\Contacts\Models\ContactList;
use App\Modules\Contacts\Models\Group;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function lists() {
        return $this->hasMany(ContactList::class);
    }
    public function listById($id) {
        return $this->hasMany(ContactList::class)->where('id','=',$id);
    }

    public function country() {
        return $this->belongsTo(Country::class);
    }

    public function contactGroups() {
        return $this->hasMany(Group::class);
    }
}
