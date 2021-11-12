<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create()
    {
        return view('client.orders.create', [
            'items' => Cart::getItems(),
            'totalAmount' => Cart::totalAmount(),
            'totalItems' => Cart::totalItems()
        ]);
    }

    public function store(Request $request)
    {
        $order = Order::query()->create([
           'amount' => Cart::totalAmount(),
            'address' => $request->get('address')

        ]);

        // کل محصولاتی که داریم را باید داخل این جدول اضافه بکنیم
        foreach (Cart::getItems() as $item)
        {
            $product = $item['product'];
            $productQty = $item['quantity'];

            // send data to orderTable
            $order->details()->create([
                'product_id' => $product->id,
                'unit_amount' => $product->cost_with_discount,
                'count' => $productQty,
                'total_amount' => $productQty * $product->cost_with_discount,
            ]);
        }


        // کامل خالی کردن سبد خرید
        Cart::removeAll();


        return redirect()->back();
    }
}
