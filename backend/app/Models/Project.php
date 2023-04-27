<?php

namespace App\Models;

use Elasticquent\ElasticquentTrait;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Project extends Model
{
    use Sluggable;
    use ElasticquentTrait;

    protected $primaryKey = 'project_id';
    protected $table = 'projects';

    protected $fillable = [
        'title', 'slug', 'description', 'attached_files', 'website_language', 'author_prefers_to_be_contacted_in', 'status', 'author_name', 'author_email', 'author_phone', 'project_address', 'region', 'start_time', 'number_of_offers', 'author_id'
    ];

    protected $mappingProperties = array(
        'title' => [
            'type' => 'text',
            "analyzer" => "standard",
        ],
        'description' => [
            'type' => 'text',
            "analyzer" => "standard",
        ],
        'author_name' => [
            'type' => 'text',
            "analyzer" => "standard",
        ],
        'author_email' => [
            'type' => 'text',
            "analyzer" => "standard",
        ],
        'author_id' => [
            'type' => 'integer',
        ],
    );

    function getIndexName()
    {
        return 'projects';
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * Get the User that owns the Project.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'id');
    }

}
