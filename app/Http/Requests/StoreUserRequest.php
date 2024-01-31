<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'adressAgence' => 'required|string|max:255',
            'dateCreationAgence' => 'required|date',
            'numeroIfu' => 'required|string|max:255',
            'rccm' => 'file|mimes:jpeg,png,pdf|max:2048',//
            // 'roles' => 'required'
        ];
    }
}
