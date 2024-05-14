<?php

namespace App\Http\Requests\Admin\Content;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
            'name' => 'required|max:120|min:2|regex:/^[a-zA-Z0-9\.,  ? ؟ا-یِ]+$/u',
            'url' => 'required|max:120|min:2|regex:/^[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-z-A-Z-0-9]\.[a-zA-Z]{2,}$/u',
            'parent_id' => 'nullable|min:1|max:10000000000|regex:/^[0-9]+$/u|exists:menus,id',
            'status' => 'required|numeric|in:0,1',
        ];
    }
}
