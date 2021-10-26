<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Category;
use App\Observers\CategoryObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // قابل دسترس کردن این متغیرها برای تمام صفحات

        // A)
        // View:: => یک کلاس برای مدیریت صفحاتمون هست
        // View::share() => برای به اشتراک گذاشتن متغیر به کل صفحات
        // View::share('categories', Category::query()->where('category_id', null)->get());
        // View::share('brands', Brand::all());

        // B)
        // view()->share('categories', Category::query()->where('category_id', null)->get());
        // view()->share('brands', Brand::all());


        // C)
        // view()->composer(['client.*'], function($view){} => با ویو های سمت کلاینت بیا این متغیر ها رو به اشتراک بگدار
        view()->composer(['client.*'], function($view){
            $view->with([
                // Category::query()->where('category_id', null)->get() => فقط دسته بندی های والد و بدون فرزند را برگردان
                'categories' => Category::query()->where('category_id', null)->get(),
                'brands' => Brand::all(),
            ]);
        });



        // model_name::observe()
        Category::observe(CategoryObserver::class);


    }
}
