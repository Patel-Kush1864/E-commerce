<?php

namespace App\Http\Requests;

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
        return [
                'category_id' => 'required|exists:categories,Cate_id',
                'ProductName' => 'required|string|max:255',
                'ProductPrice' => 'required|numeric|min:0',
                'Brand' => 'required|string|max:255',
                'ModelNumber' => 'required|string|max:255',
                'WarrantyPeriod' => 'required|string|in:6 Months,1 Year,2 Years,3 Years,5 Years',
                'ProductImage' => 'required|nullable', // optional image field
                'ProductStock' => 'required|numeric|min:0',
                'Status' => 'required|in:Active,Inactive',
                'Description' => 'required|nullable|string',
        ];
    }
}
