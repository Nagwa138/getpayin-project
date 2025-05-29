<?php

namespace App\Http\Requests\API\Platform;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PlatformToggleRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'platform' => 'required|exists:platforms,id',
            'is_active' => 'required|boolean'
        ];
    }

    /**
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge($this->route()->parameters());
    }

    /**
     * @return mixed
     */
    public function getPlatformId(): mixed
    {
        return $this->input('platform');
    }

    /**
     * @return mixed
     */
    public function getIsActive(): mixed
    {
        return $this->input('is_active');
    }
}
