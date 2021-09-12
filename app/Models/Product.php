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

}
