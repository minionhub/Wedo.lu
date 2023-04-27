<?php

namespace App\Models;

use Elasticquent\ElasticquentTrait;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use Sluggable;
    use ElasticquentTrait;

    protected $primaryKey = 'id';
    protected $table = 'posts';

    protected $fillable = ['title', 'slug', 'content', 'is_important'];

    protected $mappingProperties = array(
        'title' => [
            'type' => 'text',
            "analyzer" => "standard",
        ],
        'content' => [
            'type' => 'text',
            "analyzer" => "standard",
        ]
    );

    function getIndexName()
    {
        return 'posts';
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
     * Get the User that owns the post..
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'id');
    }

    /**
     * Get the tags for the post.
     */
    public function tags()
    {
        return $this->hasMany('App\Tag');
    }
}
