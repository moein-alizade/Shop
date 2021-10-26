<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // حتما کاربر لاگین کرده باشد برای ایجاد ثبت کامنت
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function store(Request $request, Product $product)
    {
        // dd($request->get('content'));
        $this->validate($request, [
            'content' => ['required']
        ]);

        Comment::query()->create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'content' => $request->get('content')
        ]);


        return redirect()->back();
    }
}
