<?php

namespace App\Http\Requests\GovernmentalEmployee;

use Illuminate\Foundation\Http\FormRequest;

class GovernmentalEmployeeRequest extends FormRequest
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
        $userId = $this->route('Employee') ? decrypt($this->route('Employee')) : null;
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $userId,
            'phone' => 'nullable|string|regex:/^[0-9]\d{9,12}$/',
            'address' => 'nullable|string',
            'usertype' => 'nullable',
            'type' => 'nullable',
            'password' => $userId ? 'nullable' : 'required|confirmed|min:8',
            'password_confirmation' => $userId ? 'nullable' : 'required|min:8|same:password',
        ];
    }
}
