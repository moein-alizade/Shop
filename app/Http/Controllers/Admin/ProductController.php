<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.products.index', [
            'products' => Product::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create', [
            'categories' => Category::all(),
            'brands' => Brand::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(ProductRequest $request)
    {

        $path = $request->file('image')->storeAs(
            'public/products', $request->file('image')->getClientOriginalName()
        );

        Product::query()->create([
            'name' => $request->get('name'),
            'slug' => $request->get('slug'),
            'brand_id' => $request->get('brand_id'),
            'category_id' => $request->get('category_id'),
            'cost' => $request->get('cost'),
            'description' => $request->get('description'),
            'image' => $path,
        ]);

        return redirect(route('products.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::all(),
            'brands' => Brand::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        // اگر  slug تکراری باشد و  در رکورد ها یا فیلد های دیگه استفاده شده باشد آنگاه ما باید جلوی آن را بگیریم
        // دلیل این هست که اگه اینکار رو نکنیم آنگاه اگه موقع ویرایش، slug را عوض نکنیم آنگاه به ما خطای تکراری بودن slug را می دهد در حالی که داریم برای همان رکورد ویرایش رو انجام میدهیم
        // اگه داخل رکورد ها فقط همین یک رکورد، slug فعلی را داشت آنگاه خطای گرفته شدن slug را نشان نده
         // رکوردی که slug اش برابر با slug فعلی باشد و آیدی اش اما مخالف با آیدی محصول فعلی باشد و در انتها آیا چنین رکوردی وجود دارد یا خیر
        $slugIsUsed = Product::query()
            ->where('slug',$request->get('slug'))
            ->where('id', '!=', $product->id)
            ->exists();

        if($slugIsUsed)
        {
            return back()->withErrors(['slug' => 'slug already been taken']);
        }


        $path = $product->image;

        // اگه تصویر وجود داشت آنگاه بیا مسیر رسیدن به عکس جدید را برای ما آپدیت کن
        if($request->hasFile('image'))
        {
            $path = $request->file('image')->storeAs(
                'public/products', $request->file('image')->getClientOriginalName()
            );
        }


        $product->update([
            // 'name' => $request->get('name', $product->name),
            // $product->name => استفاده کن $product مقدار پیش فرض برای زمانی که این مقادیر وجود نداشت آنگاه از مقدار قبلی خود
            // get() => بعنوان مقدار پیش فرض در نظر گرفته می شود ، get() متغیر دوم تابع
            'name' => $request->get('name', $product->name),
            'slug' => $request->get('slug', $product->slug),
            'brand_id' => $request->get('brand_id', $product->brand_id),
            'category_id' => $request->get('category_id', $product->category_id),
            'cost' => $request->get('cost', $product->cost),
            'description' => $request->get('description', $product->description),
            'image' => $path,
        ]);

        return redirect(route('products.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
