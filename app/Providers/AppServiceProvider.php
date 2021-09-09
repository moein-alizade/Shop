<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Category;
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
        view()->composer(['*'], function($view){
            $view->with([
                'categories' => Category::query()->where('category_id', null)->get(),
                'brands' => Brand::all()
            ]);
        });
    }
}
