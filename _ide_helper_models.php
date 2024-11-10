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
 * @method static \Illuminate\Database\Eloquent\Builder|Amenity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Amenity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Amenity query()
 * @method static \Illuminate\Database\Eloquent\Builder|Amenity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Amenity whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Amenity whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Amenity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Amenity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Amenity whereParentAmenity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Amenity whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Amenity whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Amenity whereUpdatedAt($value)
 */
	class Amenity extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereBackgroundImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereImageIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereParentCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereShowAtHome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
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
 * @property string|null $price_range
 * @property string|null $website
 * @property string|null $facebook_link
 * @property string|null $tiktok_link
 * @property string|null $instagram_link
 * @property string|null $youtube_link
 * @property int $is_verified
 * @property int $is_featured
 * @property string|null $file
 * @property int $views
 * @property string|null $google_map_embed_code
 * @property string $expire_date
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property int $status
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\Location $location
 * @method static \Illuminate\Database\Eloquent\Builder|Listing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Listing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Listing query()
 * @method static \Illuminate\Database\Eloquent\Builder|Listing whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing whereExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing whereFacebookLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing whereGoogleMapEmbedCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing whereInstagramLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing whereIsVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing wherePriceRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing whereThumbnailImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing whereTiktokLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing whereViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Listing whereYoutubeLink($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder|ListingAmenity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ListingAmenity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ListingAmenity query()
 * @method static \Illuminate\Database\Eloquent\Builder|ListingAmenity whereAmenityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ListingAmenity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ListingAmenity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ListingAmenity whereListingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ListingAmenity whereUpdatedAt($value)
 */
	class ListingAmenity extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|Location newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Location newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Location query()
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereLocationImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereParentLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereShowAtHome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereUpdatedAt($value)
 */
	class Location extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property bool $status
 * @property \App\Models\Category|null $category
 * @property string|null $description
 * @property string $total_price
 * @property string|null $discount_percentage
 * @property string $total_time
 * @property string $price_type
 * @property string $available_for
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PackageServiceVariant> $packageServiceVariants
 * @property-read int|null $package_service_variants_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Service> $services
 * @property-read int|null $services_count
 * @method static \Illuminate\Database\Eloquent\Builder|Package newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package query()
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereAvailableFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereDiscountPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePriceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereTotalTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereUpdatedAt($value)
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
 * @property-read \App\Models\Package $package
 * @method static \Illuminate\Database\Eloquent\Builder|PackageServiceVariant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageServiceVariant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageServiceVariant query()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageServiceVariant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageServiceVariant whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageServiceVariant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageServiceVariant wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageServiceVariant wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageServiceVariant whereTreatmentCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageServiceVariant whereTreatmentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageServiceVariant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageServiceVariant whereVariants($value)
 */
	class PackageServiceVariant extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $listing_id
 * @property string $name
 * @property string $slug
 * @property string|null $qualification
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PractitionerCertificate> $certificates
 * @property-read int|null $certificates_count
 * @method static \Illuminate\Database\Eloquent\Builder|Practitioner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Practitioner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Practitioner query()
 * @method static \Illuminate\Database\Eloquent\Builder|Practitioner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Practitioner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Practitioner whereListingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Practitioner whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Practitioner whereQualification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Practitioner whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Practitioner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Practitioner whereUserId($value)
 */
	class Practitioner extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $practitioner_id
 * @property int $certificate_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Practitioner $practitioner
 * @method static \Illuminate\Database\Eloquent\Builder|PractitionerCertificate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PractitionerCertificate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PractitionerCertificate query()
 * @method static \Illuminate\Database\Eloquent\Builder|PractitionerCertificate whereCertificateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PractitionerCertificate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PractitionerCertificate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PractitionerCertificate wherePractitionerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PractitionerCertificate whereUpdatedAt($value)
 */
	class PractitionerCertificate extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProfessionalCertificate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProfessionalCertificate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProfessionalCertificate query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProfessionalCertificate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfessionalCertificate whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfessionalCertificate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfessionalCertificate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfessionalCertificate whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfessionalCertificate whereUpdatedAt($value)
 */
	class ProfessionalCertificate extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $status
 * @property string $service_type
 * @property string|null $total_price
 * @property string $category
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ServicePriceVariant> $priceVariants
 * @property-read int|null $price_variants_count
 * @method static \Illuminate\Database\Eloquent\Builder|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereServiceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereUpdatedAt($value)
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
 * @property-read \App\Models\Service $service
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePriceVariant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePriceVariant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePriceVariant query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePriceVariant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePriceVariant whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePriceVariant whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePriceVariant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePriceVariant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePriceVariant wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePriceVariant wherePriceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePriceVariant whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServicePriceVariant whereUpdatedAt($value)
 */
	class ServicePriceVariant extends \Eloquent {}
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
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereParentCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereParentTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereUpdatedAt($value)
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $role
 * @property string $avatar
 * @property string $banner
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
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
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAbout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBanner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFacebookId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFacebookToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFbLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGoogleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIgLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProfilePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTtLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereYtLink($value)
 */
	class User extends \Eloquent {}
}

