<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function create()
    {
        return view('client.register.create');
    }


    public function sendMail(Request $request)
    {
        $this->validate($request, [
           'email' => ['required', 'email']
        ]);


        // OTP
        // random_int(min, max)
        $otp = random_int(11111, 99999);


        // Create user and store in db
        $user = User::query()->create([
            'email' => $request->get('email'),
            'role_id' => Role::findByTitle('user')->id,
            'password' => bcrypt($otp)
        ]);


        // send otp email to user
        // Email call
        // to() = مشخص کردن ایمیل مقصد
        // send('مشخص کردن کلاس موردنظر از ایمیلی که ساختیم برای فرستادن') = ایجاد ایمیل در آن لحظه ی خاص
        Mail::to($user->email)->send(new OtpMail($otp));


        //return redirect(route('register.otp'));
    }
}
