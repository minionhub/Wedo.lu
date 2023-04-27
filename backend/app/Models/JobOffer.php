<?php

namespace App\Models;

use Elasticquent\ElasticquentTrait;
use Cviebrock\EloquentSluggable\Sluggable;

class JobOffer extends Listing
{
    use Sluggable;
    use ElasticquentTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'logo_img', 'cover_img', 'full_description', 'slug', 'contact_email', 'region', 'job_title', 'contract_type',
        'pdf', 'payment', 'phone', 'website_url', 'map_longitude', 'map_latitude',
        'company_social_security_number', 'contact_person', 'level_of_luxembourgish', 'level_of_german', 'level_of_french',
        'level_of_english', 'company_id', 'user_id', 'category_id', 'company_name'
    ];

    protected $mappingProperties = array(
        'job_title' => [
            'type' => 'text',
            "analyzer" => "standard"
        ],
        'full_description' => [
            'type' => 'text',
            "analyzer" => "standard"
        ],
        'contract_type' => [
            'type' => 'text',
            "analyzer" => "standard"
        ],
        'company_name' => [
            'type' => 'text',
            "analyzer" => "standard"
        ],
        'contact_email' => [
            'type' => 'text',
            "analyzer" => "standard"
        ]
    );

    function getIndexName()
    {
        return 'joboffers';
    }

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'listing_id';

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'job_title'
            ]
        ];
    }

    /**
     * Get the company that owns the jobOffer.
     */
    public function company()
    {
        return $this->belongsTo('App\Company', 'listing_id');
    }

    /**
     * Get the contactPersons for the jobOffer.
     */
    public function contactPersons()
    {
        return $this->hasMany('App\ContactPerson');
    }
}
