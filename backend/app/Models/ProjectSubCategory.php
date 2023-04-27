<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectSubCategory extends Model
{

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'subcategory_id';
    protected $table = 'project_subcategories';

    /**
     * Get the Project for the ProjectSubCategory.
     */
    public function projects()
    {
        return $this->hasMany('App\Project');
    }

    /**
     * Get the ProjectCategory that owns the ProjectSubCategory.
     */
    public function projectCategories()
    {
        return $this->belongsTo('App\ProjectCategory', 'category_id');
    }
}
