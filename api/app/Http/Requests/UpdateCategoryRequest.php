<?php

namespace App\Http\Requests;


class UpdateCategoryRequest extends Request
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
        $categoryId = $this->route('id');

        return [
            'code_name' => 'required|string|max:255|unique:categories,code_name,' . $categoryId,
            'label' => 'required|string|max:255',
        ];
    }
}
