<?php

namespace App\Models;

use Elasticquent\ElasticquentTrait;
use Cviebrock\EloquentSluggable\Sluggable;

class Company extends Listing
{
    use Sluggable;
    use ElasticquentTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'logo_img', 'cover_img', 'full_description', 'slug', 'contact_email', 'region', 'company_name',
        'short_desc', 'street', 'houseNbr', 'zip_code', 'city', 'map_longitude', 'map_latitude', 'location', 'set_of_images', 'phone',
        'website_url', 'fax', 'e_commerce', 'social_networks', 'timezone_id', 'codeNace', 'commercialRegisterCode', 'internationalTVAnbr',
        'nationalTVAnbr', 'revenue', 'shareCapital', 'employeeNbr', 'foundationDate', 'additionalDetails', 'brands',
        'accepted_payment_methods', 'spoken_languages', 'certifications', 'facilities', 'is_premium_listing', 'user_id',
        'opening_hours'
    ];

    protected $mappingProperties = array(
        'company_name' => [
            'type' => 'text',
            "analyzer" => "standard"
        ],
        'short_desc' => [
            'type' => 'text',
            "analyzer" => "standard"
        ],
        'full_description' => [
            'type' => 'text',
            "analyzer" => "standard"
        ],
        'contact_email' => [
            'type' => 'text',
            "analyzer" => "standard"
        ],
        'location' => [
            'type' => 'geo_point'
        ]
    );

    function getIndexName()
    {
        return 'companies';
    }

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'listing_id';

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'company_name'
            ]
        ];
    }

    public function categories()
    {
        return $this->morphToMany('App\Models\Category', 'categorizable');
    }

    /**
     * Get the job offers for the company.
     */
    public function jobOffers()
    {
        return $this->hasMany('App\Models\JobOffer', 'company_id', 'listing_id');
    }

    /**
     * Get the events for the company.
     */
    public function events()
    {
        return $this->hasMany('App\Models\Event', 'company_id', 'listing_id');
    }

    /**
     * Get the promotions for the company.
     */
    public function promotions()
    {
        return $this->hasMany('App\Models\Promotion', 'company_id', 'listing_id');
    }

    /**
     * Get the contactPersons for the company.
     */
    public function contactPeople()
    {
        return $this->hasMany('App\Models\ContactPerson', 'company_id', 'listing_id');
    }

    /**
     * Get the order for the company.
     */
    public function order()
    {
        return $this->hasOne('App\Models\Order');
    }

    /**
     * Get the services for the company.
     */
    public function services()
    {
        return $this->hasMany('App\Models\Service');
    }

    /**
     * Get the addresses for the company.
     */
    public function addresses()
    {
        return $this->hasMany('App\Models\Address', 'company_id', 'listing_id');
    }
}
