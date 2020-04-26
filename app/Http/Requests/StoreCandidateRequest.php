<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCandidateRequest extends FormRequest
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
            'name' => 'required|string||max:255',
            'email' => 'required|unique:candidates|max:255',
            'web_address' => 'required|url|max:255',
            'cover_letter' => 'required',
            'resume'  => 'required|mimes:pdf,docx,doc,txt',
            'is_working'=> ['required',Rule::in([1, 0]),]
        ];
    }


    public function messages()
    {
        return [
            'url' => 'Please enter the valid URL'
        ];
    }
}
