<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    
    protected $fillable = [ 
        'settings_country_iso2',
        'settings_country_short_name',
        'settings_country_long_name',
        'settings_country_iso3',
        'settings_country_numcode',
        'settings_country_un_member',
        'settings_country_calling_code',
        'settings_country_cctld',
    ];

}
