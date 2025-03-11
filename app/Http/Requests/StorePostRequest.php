<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // اگر کاربر مجاز است، true برگردانید.
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'عنوان پست الزامی است.',
            'content.required' => 'محتوای پست الزامی است.',
            'category_id.required' => 'انتخاب دسته‌بندی الزامی است.',
            'category_id.exists' => 'دسته‌بندی انتخاب شده معتبر نیست.',
            'image.image' => 'فایل باید یک تصویر معتبر باشد.',
            'image.mimes' => 'فرمت‌های مجاز تصویر: jpeg, png, jpg, gif.',
            'image.max' => 'حداکثر حجم تصویر ۲ مگابایت است.',
        ];
    }
}
