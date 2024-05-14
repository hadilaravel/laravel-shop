<?php

namespace App\Http\Requests\Admin\Content;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
            'title' => 'required|max:120|min:2|regex:/^[a-zA-Z0-9\., ا-یِ]+$/u',
            'body' => 'required|max:500|min:5',
            'status' => 'required|numeric|in:0,1',
            'tags' => 'required|regex:/^[a-zA-Z0-9\., ا-یِ]+$/u',
        ];
    }
}
