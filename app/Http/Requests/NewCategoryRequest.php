<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewCategoryRequest extends FormRequest
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
            // 'unique:categories,title' => حتما باید یکتا باشد title و فیلد  categories داخل جدول
            'title' => ['required', 'unique:categories,title'],

            // 'exists:categories,id' => که سمت ما میاد حتما معتبر باشد و نیز حتما وجود داشته باشد در داخل جدول اگه مقدار داشت category_id
            'category_id' => ['nullable', 'exists:categories,id']
        ];
    }
}
