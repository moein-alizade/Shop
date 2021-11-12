@extends('client.layout.master')

@section('content')
    <div id="container">
        <div class="container">
            <!-- Breadcrumb Start-->
            <ul class="breadcrumb">
                <li><a href="index.html"><i class="fa fa-home"></i></a></li>
                <li><a href="cart.html">سبد خرید</a></li>
                <li><a href="checkout.html">ثبت سفارش</a></li>
            </ul>
            <!-- Breadcrumb End-->
            <div class="row">
                <!--Middle Part Start-->
                <div id="content" class="col-sm-12">
                    <h1 class="title">ثبت سفارش</h1>
                    <form action="{{route('client.orders.store')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"><i class="fa fa-ticket"></i> استفاده از کوپن تخفیف</h4>
                                    </div>
                                    <div class="panel-body">
                                        <label for="input-coupon" class="col-sm-3 control-label">کد تخفیف خود را وارد کنید</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="input-coupon" placeholder="کد تخفیف خود را در اینجا وارد کنید" value="" name="offer_code">
                                            <span class="input-group-btn">
                          <input type="button" class="btn btn-primary" data-loading-text="بارگذاری ..." id="button-coupon" value="اعمال کوپن">
                          </span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"><i class="fa fa-shopping-cart"></i> سبد خرید</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <td class="text-center">تصویر</td>
                                                    <td class="text-left">نام محصول</td>
                                                    <td class="text-left">تعداد</td>
                                                    <td class="text-right">قیمت واحد</td>
                                                    <td class="text-right">کل</td>
                                                </tr>
                                                </thead>
                                                <tbody class="cart-table-body">
                                                @foreach($items as $item)
                                                    @php
                                                        $product = $item['product'];
                                                        $productQty = $item['quantity'];
                                                    @endphp


                                                    <tr class="cart-row-{{$product->id}}">
                                                        <td class="text-center">
                                                            <a href="product.html">
                                                                <img width="100" src="{{str_replace('public', '/storage', $product->image)}}" alt="تبلت ایسر" title="تبلت ایسر" class="img-thumbnail" />
                                                            </a>
                                                        </td>
                                                        <td class="text-left"><a href="product.html">{{$product->name}}</a><br />
                                                            <small>امتیازات خرید: 1000</small></td>
                                                        <td class="text-left">{{$product->brand->name}}</td>
                                                        <td class="text-left">
                                                            <div class="input-group btn-block quantity">
                                                                <input type="text" name="qty-{{ $product->id }}" id="qty-{{ $product->id }}" value="{{$productQty}}" size="1" class="form-control" />
                                                                <span class="input-group-btn">
                                                                <button type="submit" data-toggle="tooltip" title="بروزرسانی" onclick="updateCart({{ $product->id }})" class="btn btn-primary"><i class="fa fa-refresh"></i></button>
                                                                <button type="button" data-toggle="tooltip" title="حذف" class="btn btn-danger" onClick="removeFromCart({{ $product->id }})"><i class="fa fa-times-circle"></i></button>
                                                            </span>
                                                            </div>
                                                        </td>
                                                        <td class="text-right">{{$product->cost_with_discount * $productQty}} تومان</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4 col-sm-offset-8">
                                                <table class="table table-bordered">
                                                    <tbody class="cart-table-body">
                                                    <tr>
                                                        <td class="text-right"><strong>جمع کل</strong></td>
                                                        <td class="text-right total-amount">{{\App\Models\Cart::totalAmount()}} تومان</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right"><strong>قابل پرداخت</strong></td>
                                                        <td class="text-right total-amount">{{\App\Models\Cart::totalAmount()}} تومان</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"><i class="fa fa-pencil"></i> آدرس خود را وارد نمایید.</h4>
                                    </div>
                                    <div class="panel-body">
                                        <textarea rows="4" class="form-control" id="address" name="address"></textarea>
                                        <br>
                                        <div class="buttons">
                                            <div class="pull-right">
                                                <input type="submit" class="btn btn-primary" id="button-confirm" value="تایید سفارش">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!--Middle Part End -->
            </div>
        </div>
    </div>
@endsection
