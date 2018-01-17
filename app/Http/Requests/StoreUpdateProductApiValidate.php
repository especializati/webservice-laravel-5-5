<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateProductApiValidate extends FormRequest
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
        // get id product in position URL (default null)
        $id = $this->segment(4);

        return [
            'name'          => "required|min:3|max:100|unique:products,name,{$id},id",
            'description'   => 'required|min:3|max:1500',
        ];
    }
}
