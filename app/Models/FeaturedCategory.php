<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeaturedCategory extends Model
{
    use HasFactory;

    // $incrementing = fals;   =>  باشد auto incrementing ما  primary key وقتی که نمی خواهیم
    public $incrementing = false;

    // اگر primary key ما فیلدی غیر از آیدی باشد آنگاه باید آن را اینجا معرفی بکنیم    ;'protected $primaryKey = 'category_id
    protected $primaryKey = 'category_id';


    protected $guarded = [];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public static function getCategory()
    {
        return optional(FeaturedCategory::query()->first())->category;
    }

}
