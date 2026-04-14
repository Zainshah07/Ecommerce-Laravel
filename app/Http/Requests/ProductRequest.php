<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id= $this->route('id');
        return [
        'title' => 'required|string|max:248',
        'price' => 'integer|required',
        'image'=> 'file',
        'category_id'=>'required',
        'quantity'=>'integer',
        'sku'=>'required',
        'status'=>'required',


        ];
    }

    public function messages():array{
        return[
            'title.required'=>'product name is required',

            'price.required'=>'price is required',
            // 'image.required'=>'image is required',
            'qunatity.required'=>'quantity is required',
            'status.required'=>'select a status'
        ];
    }
}
