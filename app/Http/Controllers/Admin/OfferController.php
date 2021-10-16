<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfferRequest;
use App\Http\Requests\OfferUpdateRequest;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.offers.index', [
            'offers' => Offer::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.offers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(OfferRequest $request)
    {
        Offer::query()->create([
            'code' => $request->get('code'),
            'starts_at' => $request->get('starts_at'),
            'expires_at' => $request->get('expires_at'),
        ]);



        return redirect('/adminpanel/offers');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        return view('admin.offers.edit', [
            'offer' => $offer
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(OfferUpdateRequest $request, Offer $offer)
    {
        // آیا تخفیفی وجود دارد که کدش با این کدی که request داده شده برابر باشد و در جایی غیر از تخفیف فعلی که داریم آپدیت می کنیم، آن کد استفاده شده باشد تا درنهایت کدهای تخفیفان بصورت یکتا باقی بمانند
        $codeIsNotUnique = Offer::query()
            ->where('code', $request->get('code'))
            ->where('id', '!=', $offer->id)
            ->exists();



        if($codeIsNotUnique)
        {
            return redirect()->back()
                ->withErrors(['code' => 'code must be unique.']);
        }



        $offer->update([
            'code' => $request->get('code'),
            'starts_at' => $request->get('starts_at'),
            'expires_at' => $request->get('expires_at'),
        ]);


        return redirect(route('offers.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer)
    {
        //
    }
}
