<?php

namespace Modules\PostCategory\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:120|min:2|regex:/^[a-zA-Z0-9\., ا-یِ]+$/u',
            'description' => 'required|max:500|min:5|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\n\r&?؟ ]+$/u',
            'image' => 'image|mimes:png,jpg,jpeg,gif',
            'status' => 'required|numeric|in:0,1',
            'tags' => 'required|regex:/^[a-zA-Z0-9\., ا-یِ]+$/u',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
