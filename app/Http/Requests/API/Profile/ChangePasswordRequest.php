<?php

namespace App\Http\Requests\API\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * @return true
     */
    public function authorize(): true
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'new_password.confirmed' => 'The new password confirmation does not match.',
        ];
    }
}
