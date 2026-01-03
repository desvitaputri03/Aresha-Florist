<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    protected $fillable = [
        'address',
        'phone_number',
        'email',
        'operating_hours',
        'google_maps_link',
        'whatsapp_number',
        'about_us_description',
        'history',
        'vision',
        'mission',
    ];
}
