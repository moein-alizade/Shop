<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
        // mimes:png,jpg,jpeg,mpeg' => فرمت های قابل قبول برای ما را اعتبار سنجی می کند
        // max:1024 => max volume(KB)
        // min:50 => min volume(KB)
        return [
            'name' => ['required'],
            'image' => ['required', 'mimes:png,jpg,jpeg,mpeg', 'max:1024', 'min:50']
        ];
    }
}
