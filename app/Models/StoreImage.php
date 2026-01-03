<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreImage extends Model
{
    protected $fillable = ['image_path', 'order'];
}
