<?php

namespace App\Models;

use App\Mail\OtpMail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function role()
    {
        return $this->belongsTo(Role::class);
    }


    public static function generateOtp(Request $request)
    {
        $user = null;


        // OTP
        // random_int(min, max)
        $otp = random_int(11111, 99999);



        $userQuery = User::query()->where('email', $request->get('email'));


        // اگر کاربر از قبل وجود داشت باز هم یک کدی را براش ارسال بکنیم که بتواند لاگین کند از طریق فقط یک تابع
        if($userQuery->exists())
        {
            $user = $userQuery->first();


            $user->update([
                'password' => bcrypt($otp)
            ]);
        }

        else {
            // Create user and store in db
            $user = User::query()->create([
                'email' => $request->get('email'),
                'role_id' => Role::findByTitle('user')->id,
                'password' => bcrypt($otp)
            ]);
        }


        // send otp email to user
        // Email call
        // to() = مشخص کردن ایمیل مقصد
        // send('مشخص کردن کلاس موردنظر از ایمیلی که ساختیم برای فرستادن') = ایجاد ایمیل در آن لحظه ی خاص
        Mail::to($user->email)->send(new OtpMail($otp));


        return $user;
    }
}
