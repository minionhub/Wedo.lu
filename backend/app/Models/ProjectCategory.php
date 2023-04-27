<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'category_id';

    /**
     * Get the ProjectSubCategory for the ProjectCategory.
     */
    public function projectSubCategories()
    {
        return $this->hasMany('App\ProjectSubCategory');
    }
}
