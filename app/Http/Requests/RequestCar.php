<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RequestCar extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'plate' => 'required|min:7|max:8|unique:cars',
            'model' => 'required|min:3|max:100',
            'brand' => 'required|min:3|max:100'
        ];

        if ($this->method() === 'PUT' || $this->method() === 'PATCH') {
            $rules['plate'] = [
                'required', // 'nullable',
                'min:7',
                'max:8',
                // "unique:supports,subject,{$this->id},id",
                Rule::unique('cars')->ignore($this->car ?? $this->id),
            ];
        }
        return $rules;
    }
}
