<?php

namespace App\Models;


use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function pictures()
    {
        return $this->hasMany(Picture::class);
    }


    public function discount()
    {
        return $this->hasOne(Discount::class);
    }

    public function addPicture(Request $request)
    {
        $path = $request->file('image')->storeAs(
            'public/products/pictures',
            $request->file('image')->getClientOriginalName()
        );

        $this->pictures()->create([
            'path' => $path,
            // type file
            'mime' => $request->file('image')->getClientMimeType()
        ]);
    }

    public function deletePicture(Picture $picture)
    {
        // 1) Remove file (تا وقتی رکورد از دیتابیس حذف شد دیگه فایل عکس توی پوشه تصاویر پابلیک مون وجود نداشته باشد)
        Storage::delete($picture->path);

        // 2) Remove record from database
        $picture->delete();
    }


    public function addDiscount(Request $request)
    {
        // آیا برای این محصول قبلا تخفیفی ثبت شده یا نه
        if(!$this->discount()->exists())
        {
            $this->discount()->create([
                'value' => $request->get('value')
            ]);
        }
        else
        {
            // discount = attribute -> یعنی نتیجه اش یک رکورد از دیتابیس است
            // discount() = function -> نتیجه اش یک کوئری هست و بصورت رکورد نیست
            $this->discount->update([
               'value' => $request->get('value')
            ]);
        }

    }


    public function deleteDiscount()
    {
        $this->discount()->delete();
    }


    // get + function_name + Attribute=> تعریف تابع بصورت فیلد مجازی
    public function getCostWithDiscountAttribute()
    {
        //  آیا این محصول تخفیف دارد یا نه
        if (!$this->discount()->exists())
        {
            // return real cost
            return $this->cost;
        }

        // return costWithDiscount ( real cost - (real cost * discount percent) )
        return $this->cost - $this->cost * $this->discount->value / 100;
    }


    public function getHasDiscountAttribute()
    {
        return $this->discount()->exists();
    }


    public function getDiscountValueAttribute()
    {
        if($this->has_discount)
        {
            return $this->discount->value;
        }

        return null;
    }


    public function properties()
    {
        // withPivot(['']) => را می نویسیم (property_id & product_id) لیست فیلد هایی که قرار است به جدول اضافه شوند علاوه بر آیدی دو تا جدول
        return $this->belongsToMany(Property::class)
            ->withPivot(['value'])
            ->withTimestamps();
    }


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes')
            ->withTimestamps();
    }


    // چک می کند که این محصول توسط این کاربر فعلی مون لایک شده یا نه
    public function getIsLikedAttribute()
    {
        return $this->likes()->where('user_id', auth()->id())->exists();
    }

}
