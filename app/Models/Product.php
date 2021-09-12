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

}
