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


    // برای هر دسته بندی اصلی اگه اون دسته بندی فرزندی داشته باشد بیا محصولات همه فرزندان آن دسته بندی را برای ما برگردون
    public function getAllSubCategoryProducts()
    {
        // pluck('') => یک فیلد خاصی از اون جدولی که می خواهیم برای ما بر می گرداند

        // بدست آوردن آیدی فرزندان این دسته بندی خاص را برگردان
        $childrenIds = $this->children()->pluck('id');


        // دنبال محصولاتی بگرد که آیدی های فرزندان این دسته بندی را در خودش دارد
        // whereIn('category_id', $childrenIds) => محصولات مربوط به فرزندان دسته بندی رو بگرد و در صورت وجود آنها را نمایش بده
        // orWhere('category_id', $this->id) =>  محصولات خود دسته بندی را بگرد و در صورت وجود آنها را نمایش بده
        return Product::query()
            ->whereIn('category_id', $childrenIds)
            ->orWhere('category_id', $this->id)
            ->get();
    }


    public function getHasChildrenAttribute()
    {
        return $this->children()->count() > 0;
    }

}
