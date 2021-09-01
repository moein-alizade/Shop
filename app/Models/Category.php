<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];


    // one to one (show parent a category)
    public function parent()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }


    // one to n (find children a category or subCategory)
    public function children()
    {
        return $this->hasMany(Category::class, 'category_id');
    }

}
