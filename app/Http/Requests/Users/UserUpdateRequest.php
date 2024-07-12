<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
use App\Models\User;

class UserUpdateRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->user,
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'passwprd_confirmation' => 'sometimes|required_with:password|same:password',
            // 'role' => 'nullable|string',
            'avatar' => 'image|mimes:png,jpg,jpeg',
        ];
    }
}
