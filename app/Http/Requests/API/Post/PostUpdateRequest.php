<?php

namespace App\Http\Requests\API\Post;

use App\Architecture\Repositories\Interfaces\IPostRepository;
use App\Rules\PlatformContentRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $post = app(IPostRepository::class)->first(['id' => $this->route('post')]);
        return $post && auth()->user()->can('update', $post);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'post' => 'required|exists:posts,id',
            'title' => 'sometimes|required|string|max:255',
            'content' => [
                'sometimes',
                'required',
                'string',
                new PlatformContentRule
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'scheduled_time' => 'sometimes|required|date|after_or_equal:now',
            'status' => 'sometimes|required|string|in:draft,scheduled,published',
        ];
    }

    public function getPostId(): mixed
    {
        return $this->input('post');
    }

    protected function prepareForValidation(): void
    {
        $this->merge($this->route()->parameters());
    }
}
