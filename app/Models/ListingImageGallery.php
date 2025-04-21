<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingImageGallery extends Model
{
    //
    protected $fillable = [
        'listing_id',
        'image'
    ];
}