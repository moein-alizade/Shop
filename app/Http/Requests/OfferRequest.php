<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => ['required', 'unique:offers,code'],

            // before:expires_at => همیشه زمان شروع باید قبل از زمان پایانی باشد
            'starts_at' => ['required', 'date', 'before:expires_at'],
            'expires_at' => ['required', 'date', 'after:start_at'],
        ];
    }
}
