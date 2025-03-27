<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    function category(): BelongsTo
    {
        return  $this->belongsTo(Category::class);
    }

    function practitioner(): BelongsTo
    {
        return  $this->belongsTo(Practitioner::class);
    }

    function location(): BelongsTo
    {
        return  $this->belongsTo(Location::class);
    }

    function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function listingTags()
    {
        return $this->hasMany(ListingTag::class, 'listing_id');
    }

    public function listingCertificates()
    {
        return $this->hasMany(ListingCertificate::class, 'listing_id');
    }


    public function listingPractitioners()
    {
        return $this->hasMany(ListingPractitioner::class, 'listing_id');
    }

    public function listingAmenities()
    {
        return $this->hasMany(ListingAmenity::class, 'listing_id');
    }
}