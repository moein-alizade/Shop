<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;


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

        // invoice => صورت حساب برای مقداری که قرار هست پرداخت بشود را تعیین بکنیم
        $invoice = (new Invoice)->amount($order->amount);

        // انجام شدن پرداخت
        return Payment::purchase($invoice, function ($driver, $transactionId) use ($order){
            $order->update([
                'transaction_id' => $transactionId
            ]);
        })->pay()->render();


        return redirect()->back();
    }


    public function callback(Request $request)
    {
        // dd($request->all());
        $order = Order::query()->where('transaction_id', '=', $request->get('Authority'))->first();

        $order->update([
            'payment_status' => $request->get('Status')
        ]);


        return redirect(route('client.orders.show', $order));
    }


    public function show(Order $order)
    {
        return view('client.orders.show', [
            'order' => $order
        ]);
    }

}
