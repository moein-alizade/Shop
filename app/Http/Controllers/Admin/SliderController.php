<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Models\Brand;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.sliders.index', [
            'sliders' => Slider::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SliderRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(SliderRequest $request)
    {
        $path = $request->file('image')->storeAs(
            'public/sliders',
            $request->file('image')->getClientOriginalName()
        );



        // save in database
        Slider::query()->create([
            'link' => $request->get('link'),
            'image' => $path
        ]);


        return redirect(route('sliders.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', [
            'sliders' => $slider
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SliderRequest $request
     * @param \App\Models\Slider $slider
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Slider $slider)
    {
        $this->validate($request, [
            'link' => ['required']
        ]);


        $path = $slider->image;

        // برای اینکه اگه کاربر تصویر جدید آپلود کرد آنگاه توی دیتابیس ذخیره کن
        // hasFile('image') => بریز $path بود آنگاه بیا مسیر فایل جدید را درون 'request' داخل 'image' چک می کند که یک فایلی آپلود شده یا خیر یعنی چک می کند اگه فایلی بنام
        if($request->hasFile('image'))
        {
            $path = $request->file('image')->storeAs(
                'public/sliders', $request->file('image')->getClientOriginalName()
            );
        }

        $slider->update([
            'link' => $request->get('link'),
            'image' => $path,
        ]);

        return redirect(route('sliders.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
       Storage::delete($slider->image);
       $slider->delete();
       return redirect(route('sliders.index'));
    }
}
