<?php

namespace App\Http\Requests\Customer\Profile;

use Illuminate\Foundation\Http\FormRequest;

class TicketProfileRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'subject' => 'required|min:2|max:100' ,
            'description' => 'required|min:2|max:1000' ,
            'category_id' => 'required|min:1|max:1000000000|exists:ticket_categories,id' ,
            'priority_id' => 'required|min:1|max:1000000000|exists:ticket_priorities,id' ,
            'file' => 'mimes:png,jpg,jpeg,gif' ,
        ];
    }
}
