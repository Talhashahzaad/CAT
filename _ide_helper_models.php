<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $icon
 * @property string $name
 * @property string $slug
 * @property int $status
 * @property string $parent_amenity
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TFactory|null $use_factory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Amenity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Amenity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Amenity query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Amenity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Amenity whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Amenity whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Amenity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Amenity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Amenity whereParentAmenity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Amenity whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Amenity whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Amenity whereUpdatedAt($value)
 */
	class Amenity extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $image
 * @property int $blog_category_id
 * @property int $author_id
 * @property string $title
 * @property string $views
 * @property string $slug
 * @property string $description
 * @property int $status
 * @property int $is_popular
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BlogCategory $category
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereBlogCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereIsPopular($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blog whereViews($value)
 */
	class Blog extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogCategory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlogCategory whereUpdatedAt($value)
 */
	class BlogCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $video_url
 * @property string $video_title
 * @property string|null $video_description
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatVideoUpload newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatVideoUpload newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatVideoUpload query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatVideoUpload whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatVideoUpload whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatVideoUpload whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatVideoUpload whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatVideoUpload whereVideoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatVideoUpload whereVideoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatVideoUpload whereVideoUrl($value)
 */
	class CatVideoUpload extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $image_icon
 * @property string|null $background_image
 * @property int $show_at_home
 * @property int $status
 * @property string $parent_category
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TFactory|null $use_factory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereBackgroundImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereImageIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereParentCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereShowAtHome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact whereUpdatedAt($value)
 */
	class Contact extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 * @property int $location_id
 * @property int|null $package_id
 * @property string $image
 * @property string $thumbnail_image
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $phone
 * @property string $email
 * @property string $address
 * @property string $service_capacity
 * @property string|null $website
 * @property string|null $facebook_link
 * @property string|null $tiktok_link
 * @property string|null $instagram_link
 * @property string|null $youtube_link
 * @property int $is_verified
 * @property int $is_featured
 * @property int $views
 * @property string|null $google_map_embed_code
 * @property string|null $file
 * @property string $expire_date
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property int $status
 * @property int $is_approved
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\TFactory|null $use_factory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ListingAmenity> $listingAmenities
 * @property-read int|null $listing_amenities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ListingCertificate> $listingCertificates
 * @property-read int|null $listing_certificates_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ListingPractitioner> $listingPractitioners
 * @property-read int|null $listing_practitioners_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ListingTag> $listingTags
 * @property-read int|null $listing_tags_count
 * @property-read \App\Models\Location $location
 * @property-read \App\Models\Practitioner|null $practitioner
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereFacebookLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereGoogleMapEmbedCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereInstagramLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereIsVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereServiceCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereThumbnailImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereTiktokLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereYoutubeLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing withoutTrashed()
 */
	class Listing extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $listing_id
 * @property int $amenity_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TFactory|null $use_factory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingAmenity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingAmenity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingAmenity query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingAmenity whereAmenityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingAmenity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingAmenity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingAmenity whereListingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingAmenity whereUpdatedAt($value)
 */
	class ListingAmenity extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingCategory query()
 */
	class ListingCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $listing_id
 * @property int $certificates_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingCertificate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingCertificate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingCertificate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingCertificate whereCertificatesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingCertificate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingCertificate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingCertificate whereListingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingCertificate whereUpdatedAt($value)
 */
	class ListingCertificate extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $listing_id
 * @property string $image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingImageGallery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingImageGallery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingImageGallery query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingImageGallery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingImageGallery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingImageGallery whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingImageGallery whereListingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingImageGallery whereUpdatedAt($value)
 */
	class ListingImageGallery extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $type
 * @property string $name
 * @property float $price
 * @property int $status
 * @property int $number_of_days
 * @property int $num_of_listing
 * @property int $cat_ecommarce
 * @property int $cat_pro_social_media
 * @property int $social_media_post
 * @property int $live_chat
 * @property int $multiple_locations
 * @property int $featured_listing
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TFactory|null $use_factory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPackage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPackage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPackage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPackage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPackage whereCatEcommarce($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPackage whereCatProSocialMedia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPackage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPackage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPackage whereFeaturedListing($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPackage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPackage whereLiveChat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPackage whereMultipleLocations($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPackage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPackage whereNumOfListing($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPackage whereNumberOfDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPackage wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPackage whereSocialMediaPost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPackage whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPackage whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPackage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPackage withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPackage withoutTrashed()
 */
	class ListingPackage extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $listing_id
 * @property int $practitioner_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPractitioner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPractitioner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPractitioner query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPractitioner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPractitioner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPractitioner whereListingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPractitioner wherePractitionerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingPractitioner whereUpdatedAt($value)
 */
	class ListingPractitioner extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $listing_id
 * @property string $day
 * @property string $start_time
 * @property string $end_time
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingSchedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingSchedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingSchedule query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingSchedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingSchedule whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingSchedule whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingSchedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingSchedule whereListingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingSchedule whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingSchedule whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingSchedule whereUpdatedAt($value)
 */
	class ListingSchedule extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $listing_id
 * @property int $tag_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingTag query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingTag whereListingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingTag whereTagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingTag whereUpdatedAt($value)
 */
	class ListingTag extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $listing_id
 * @property string $video_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingVideoGallery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingVideoGallery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingVideoGallery query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingVideoGallery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingVideoGallery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingVideoGallery whereListingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingVideoGallery whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingVideoGallery whereVideoUrl($value)
 */
	class ListingVideoGallery extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $location_image
 * @property int $show_at_home
 * @property int $status
 * @property string $parent_location
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TFactory|null $use_factory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereLocationImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereParentLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereShowAtHome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Location whereUpdatedAt($value)
 */
	class Location extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $user_id
 * @property string $name
 * @property string $slug
 * @property bool $status
 * @property \App\Models\Category|null $category
 * @property string|null $description
 * @property string $total_price
 * @property numeric|null $discount_percentage
 * @property string $total_time
 * @property string $price_type
 * @property string $available_for
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TFactory|null $use_factory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PackageServiceVariant> $packageServiceVariants
 * @property-read int|null $package_service_variants_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Service> $services
 * @property-read int|null $services_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package whereAvailableFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package whereDiscountPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package wherePriceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package whereTotalTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Package whereUserId($value)
 */
	class Package extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $package_id
 * @property string|null $treatment_name
 * @property string|null $treatment_category
 * @property string|null $variants
 * @property string $duration
 * @property string|null $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TFactory|null $use_factory
 * @property-read \App\Models\Package $package
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PackageServiceVariant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PackageServiceVariant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PackageServiceVariant query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PackageServiceVariant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PackageServiceVariant whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PackageServiceVariant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PackageServiceVariant wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PackageServiceVariant wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PackageServiceVariant whereTreatmentCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PackageServiceVariant whereTreatmentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PackageServiceVariant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PackageServiceVariant whereVariants($value)
 */
	class PackageServiceVariant extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TFactory|null $use_factory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentSetting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaymentSetting whereValue($value)
 */
	class PaymentSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $listing_id
 * @property string $name
 * @property string $slug
 * @property string|null $qualification
 * @property string|null $certificate
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TFactory|null $use_factory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practitioner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practitioner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practitioner query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practitioner whereCertificate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practitioner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practitioner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practitioner whereListingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practitioner whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practitioner whereQualification($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practitioner whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practitioner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practitioner whereUserId($value)
 */
	class Practitioner extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $user_id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TFactory|null $use_factory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfessionalCertificate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfessionalCertificate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfessionalCertificate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfessionalCertificate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfessionalCertificate whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfessionalCertificate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfessionalCertificate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfessionalCertificate whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfessionalCertificate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProfessionalCertificate whereUserId($value)
 */
	class ProfessionalCertificate extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $user_id
 * @property string $name
 * @property string $slug
 * @property int $status
 * @property string $service_type
 * @property string|null $total_price
 * @property string $category
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TFactory|null $use_factory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ServicePriceVariant> $priceVariants
 * @property-read int|null $price_variants_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereServiceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Service whereUserId($value)
 */
	class Service extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $service_id
 * @property string|null $name
 * @property string|null $description
 * @property string $duration
 * @property string $price_type
 * @property string|null $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TFactory|null $use_factory
 * @property-read \App\Models\Service $service
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicePriceVariant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicePriceVariant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicePriceVariant query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicePriceVariant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicePriceVariant whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicePriceVariant whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicePriceVariant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicePriceVariant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicePriceVariant wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicePriceVariant wherePriceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicePriceVariant whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ServicePriceVariant whereUpdatedAt($value)
 */
	class ServicePriceVariant extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TFactory|null $use_factory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereValue($value)
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $status
 * @property string $parent_tag
 * @property string $parent_category
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TFactory|null $use_factory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereParentCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereParentTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tag whereUpdatedAt($value)
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $role
 * @property string|null $avatar
 * @property string|null $banner
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $heard_about_options
 * @property string|null $business_location
 * @property string|null $business_size
 * @property string|null $premises_count
 * @property string|null $main_location
 * @property string|null $age_group
 * @property string|null $google_id
 * @property string|null $facebook_id
 * @property string|null $facebook_token
 * @property string|null $profile_picture
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $about
 * @property string|null $website
 * @property string|null $fb_link
 * @property string|null $tt_link
 * @property string|null $yt_link
 * @property string|null $ig_link
 * @property string $status
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \App\Models\TFactory|null $use_factory
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAbout($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAgeGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBanner($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBusinessLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereBusinessSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFacebookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFacebookToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFbLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereGoogleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereHeardAboutOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIgLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereMainLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePremisesCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereProfilePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTtLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereYtLink($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserBusinessCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserBusinessCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserBusinessCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserBusinessCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserBusinessCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserBusinessCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserBusinessCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserBusinessCategory whereUserId($value)
 */
	class UserBusinessCategory extends \Eloquent {}
}

