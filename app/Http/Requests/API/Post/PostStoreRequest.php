<?php

namespace App\Http\Requests\API\Post;

use App\Rules\PlatformAllowedRule;
use App\Rules\PlatformContentRule;
use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): true
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'platforms' => [
                'required',
                'array',
                'min:1'
            ],
            'content' => [
                'required',
                'string',
                new PlatformContentRule
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'scheduled_time' => 'required|date|after_or_equal:now',
            'platforms.*' => [
                'sometimes',
                'integer',
                'exists:platforms,id',
                new PlatformAllowedRule
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'platforms.required' => 'Please select at least one platform.',
            'scheduled_time.after_or_equal' => 'Scheduled time must be in the future.',
        ];
    }
}
