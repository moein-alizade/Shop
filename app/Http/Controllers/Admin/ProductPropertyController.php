<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductPropertyController extends Controller
{
    // Product $product => product یک محصول از جنس مذل
    public function index(Product $product)
    {
        return view('admin.productProperty.index', [
            'product' => $product
        ]);
    }


    public function create(Product $product)
    {
        return view('admin.productProperty.create', [
            'product' => $product
        ]);
    }



    public function store(Request $request, Product $product)
    {
        // فقط property هایی را برگردان که value دارند
        // collect() = تبدیل یک سری آرایه به کالکشن
        $properties = collect($request->get('properties'))->filter(function ($item){
            // !empty($item['value']) =>  اون آیتم خاص که در حال پیمایش هست خالی نبود آنگاه آن را بازگردان تا مقدار تهی توی دیتابیس ذخیره نشود value اگه ایندکس
            if (!empty($item['value']))
            {
                return $item;
            }
        });

        // dd($request->get('properties'), $properties);
        // $request->get('properties') => فقط شامل یک مجموعه آرایه هست
        // collect($request->get('properties') => هست که این کلاس یک سری توابع دارد که می توانیم خیلی راحت از یک سری توابع کلاس کالکشن استفاده کنیم collection اینها بصورت آبجکتی که شامل یک سری آیتم هست ، آبجکتی از کلاس
        // collect() => خروجی اش یک آبجکت کلاس کالکشن هست


        // sync() => و همه ی این موارد از همین صفحه استفاده بکنیم و صفحه دیگه استفاده نمی کنیم store and edit دلیل استفاده ازش این هست که قراره ما برای
        $product->properties()->sync($properties);

        return redirect()->back();
    }
}
