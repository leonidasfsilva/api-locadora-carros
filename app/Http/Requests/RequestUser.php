<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RequestUser extends FormRequest
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
            'email' => 'required|min:6|max:100|unique:users|email',
            'name'  => 'required|min:4|max:100'
        ];

        if ($this->method() === 'PUT' || $this->method() === 'PATCH') {
            $rules['email'] = [
                'required', // 'nullable',
                'min:6',
                'max:100',
                'email',
                Rule::unique('users')->ignore($this->user ?? $this->id),
            ];
        }
        return $rules;
    }
}
