<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.brands.index', [
            'brands' => Brand::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(BrandRequest $request)
    {
        // upload file

        // file('image') => هست، می توان به اطلاعات عکس پی ببریم $request با استفاده از این تابع که در آبجکت
        // dd($request->file('image'));

        // save file in laravel
        // $request->file('image')->store('image') => (Path: storage/app/image)


        // $path = مسیر رسیدن به فایل آپلود یا ذخیره شده در دیتابیس
        // $path = $request->file('image')->store('image');

        // storeAs('image', 'brand_image') => باشد jpg با استفاده از متغیر دوم این تابع می توان اسم فایل آپلود شده را شخصی سازی کرد که کد روبرو یعنی فرمت فایل حتما باید
        // $path = $request->file('image')->storeAs('image', 'brand_image.jpg');

        // getClientOriginalName() => اسم واقعی فایل رو بر می گرداند
        $path = $request->file('image')->storeAs(
            'public/image',
            $request->file('image')->getClientOriginalName()
        );



        // save in database
        Brand::query()->create([
            'name' => $request->get('name'),
            'image' => $path
        ]);

        return redirect(route('brands.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        return view('admin/brands/edit', [
           'brand' => $brand
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(BrandUpdateRequest $request, Brand $brand)
    {
        $path = $brand->image;

        // برای اینکه اگه کاربر تصویر جدید آپلود کرد آنگاه توی دیتابیس ذخیره کن
        // hasFile('image') => بریز $path بود آنگاه بیا مسیر فایل جدید را درون 'request' داخل 'image' چک می کند که یک فایلی آپلود شده یا خیر یعنی چک می کند اگه فایلی بنام
        if($request->hasFile('image'))
        {
            $path = $request->file('image')->storeAs(
                'public/image', $request->file('image')->getClientOriginalName()
            );
        }

        $brand->update([
            'name' => $request->get('name'),
            'image' => $path,
        ]);

        return redirect(route('brands.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        //
    }
}
