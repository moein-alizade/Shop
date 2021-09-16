<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyOtpRequest;
use App\Mail\OtpMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

        return redirect(route('client.register.otp', $user));
    }


    public function otp(User $user)
    {
        return view('client.register.otp', [
            'user' => $user
        ]);
    }


    public function verifyOtp(VerifyOtpRequest $request, User $user)
    {
        // چک کردن درست بودن  otp وارد شده توسط کاربر
        // Hash::check() =>  class: Hash , function: check()
        if (!Hash::check($request->get('otp'), $user->password))
        {
            return back()->withErrors(['otp' => 'کد وارد شده صحیح نیست']);
        }

        // لاگین کردن کاربر
        auth()->login($user);


        return redirect(route('client.index'));
    }

}
