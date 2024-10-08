<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $userId = $this->route('User') ? decrypt($this->route('User')) : null;
        $usingPassword = $this->input('usingPassword') ?? null;
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $userId,
            'phone' => 'nullable',
            'usertype' => 'required|string|not_in:empty|in:Admin,Requests,Remarks,Customer,Governmental,AdminGovernmental,Company',
            'tax_number' => 'nullable|string',
            'address' => 'nullable|string',
            'usingPassword' => 'sometimes|string',
            'password' => $usingPassword ? 'required|min:8' : 'nullable',
            'password_confirmation' => $usingPassword ? 'required|min:8|same:password' : 'nullable',
        ];
    }
}
