<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostSaveRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required',
            'user_id' => 'required',
            'image' => 'file',
        ];
    }

    public function messages()

    {

        return [

            'title.required' => 'The title can not be blank value',
            'content.requied' => 'The content can not be blank value',
            'category_id.required' => 'Choose one of the category type'
        ];
    }
}
