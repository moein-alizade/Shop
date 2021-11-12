<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Cart
{

    public static function new(Product $product, Request $request)
    {

        // چک کنیم که آیا توی session قبلا سبد خرید ایجاد شده یا نه
        // آیا قبلا سبد خرید داریم یا نه
        if (session()->has('cart'))
        {
            // get session cart => گرفتن و ذخیره سبد خرید
            $cart = self::getCart();
        }




        // اگه قبلا این محصولی که الان می خواهیم اضافه کنیم، در سبد خرید بود یعنی خواستیم محصول تکراری اضافه کنیم آنگاه اگه قبلا بود بیا تعداد قبلی را با تعداد جدید جمع کن و در quantity$ بریز
        // اگه قبلا نبود آنگاه بیا همان مقدار قبلی را در quantity$ بریز
        $quantity = isset(self::getCart()[$product->id]) ? ($request->get('quantity') + self::getCart()[$product->id]['quantity']) : $request->get('quantity');



        // وقتی که می خواهیم آیتم یا عنصر جدید به انتهای یک آرایه اضافه کنیم از سینتکس زیر استفاده می کنیم
        // اگر یک محصول تکراری قرار بود به سبد خرید اضافه بشود، یکطور خاصی انجام بدهیم که اجازه ندهیم این رکوردهای تکراری توی ایندکس های مختلف قرار بگیرند
        // $cart[$product->id] => یعنی اگر محصولی قرار بود چند بار کلیک و  به سبد خرید اضافه شود آنگاه بیاید جای رکورد قبلی خودش قرار بگیرد
        $cart[$product->id] = [
            'product' => $product,
             'quantity' => $quantity
        ];


        // اضافه کردن محصول جدید به سبد
        session()->put([
            'cart' => $cart
        ]);


        // Update totalItems and totalAmount
        $cart['total_items'] = Cart::totalItems();
        $cart['total_amount'] = Cart::totalAmount();




         // اضافه کردن همه محتوایی که وجود دارد به cart یا همان سبد خرید
        session()->put([
            'cart' => $cart
        ]);


    }

    // محاسبه مجموع قیمت محصولات سبد خرید
    public static function totalAmount()
    {

        $totalAmount = 0;

        if(!self::getCart())
        {
            return 0;
        }

        foreach (self::getCart() as $cartItem) {
            // اگر این دو تا ایندکس وجود داشت
            if (is_array($cartItem) && array_key_exists('product', $cartItem) && array_key_exists('quantity', $cartItem)) {
                // تعداد آن محصول توی سبد خرید * قیمت تخفیف خورده ( یا تخفیف نخورد) محصول =+ قیمت فعلی سبد خرید
                $totalAmount += $cartItem['product']->cost_with_discount * $cartItem['quantity'];
            }
        }



        return $totalAmount;
    }


    public static function getItems()
    {
        // استفاده از کالکشن و فیلتر کردن آرایه ی items
        if(!self::getCart())
        {
           return [];
        }

        return collect(self::getCart())->filter(function ($item){
            // اگه آرایه بود آنگاه بیا آیتم را بگردان
            return is_array($item);
        });

    }



    public static function totalItems()
    {

        $items = self::getItems();

        if(!$items)
        {
            return [];
        }

        return count($items);
    }


    public static function getCart()
    {
        // اگه cart نداشت آنگاه null را بازگردان
        if(!session()->has('cart'))
        {
            return null;
        }

        return session()->get('cart');
    }



    public static function remove(Product $product)
    {
        // چک کنیم که آیا توی session قبلا سبد خرید ایجاد شده یا نه
        // آیا قبلا سبد خرید داریم یا نه
        if (session()->has('cart'))
        {
            // get session cart => گرفتن و ذخیره سبد خرید
            $cart = self::getCart();
        }




        // A)  زمانی که آیتم های ما آرایه هستند می توانیم از روش زیر استفاده بکنیم
        //        if (array_key_exists($product->id, $cart))
        //        {
        //            // unset => حذف کردن
        //            unset($product->id, $cart);
        //        }




        // B)  زمانی که آیتم های ما کالکشن هستند می توانیم از روش زیر استفاده بکنیم
        $cart = collect($cart)->forget($product->id);

        // اضافه کردن محصول جدید به سبد
        session()->put([
            'cart' => $cart
        ]);


        // بعد از حذف کردن عنصر یا همان آیتم موردنظر ما سایر عناصر را حذف می کنیم
        // Update totalItems and totalAmount
        $cart['total_amount'] = self::totalAmount();
        $cart['total_items'] = self::totalItems();


        // اضافه کردن همه محتوایی که وجود دارد به cart یا همان سبد خرید
        session()->put([
            'cart' => $cart
        ]);

    }
}
