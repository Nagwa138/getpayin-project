<?php

namespace App\Rules;

use App\Architecture\Repositories\Interfaces\IPlatformRepository;
use App\Architecture\Repositories\Interfaces\IPostRepository;
use Illuminate\Contracts\Validation\Rule;

class PlatformContentRule implements Rule
{
    /**
     * @var string
     */
    protected string $message = '';

    /**
     * @var bool
     */
    protected bool $passed = true;

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        // according to chosen platforms we will return message errors for current content
        if ($postId = request()->route('post')) {
            $platformTypes = app(IPostRepository::class)->first(['id' => $postId])?->platforms()->pluck('type')->toArray();
        } else {
            $platformTypes = app(IPlatformRepository::class)->getTypesByIds(request('platforms'));
        }

        foreach ($platformTypes as $platformType) {

            if ($platformType == 'twitter') $this->validateTwitter($value);
            if ($platformType == 'instagram') $this->validateInstagram($value);
            if ($platformType == 'linkedin') $this->validateLinkedIn($value);

        }

        return $this->passed;
    }

    protected function validateTwitter($content): void
    {
        // Twitter character limit
        if (strlen($content) > 280) {
            $this->message = 'Twitter posts cannot exceed 280 characters';
            $this->passed = false;
        }

        // Twitter link handling
        if (str_word_count($content) < 5 && preg_match('/https?:\/\/\S+/', $content)) {
            $this->message = 'Twitter posts with links should have at least 5 words';
            $this->passed = false;
        }
    }

    protected function validateInstagram($content): void
    {
        // Instagram hashtag requirements
        $hashtagCount = substr_count($content, '#');
        if ($hashtagCount < 1) {
            $this->message = 'Instagram posts should include at least one hashtag';
            $this->passed = false;
        }

        // Instagram character limit
        if (strlen($content) > 2200) {
            $this->message = 'Instagram captions cannot exceed 2200 characters';
            $this->passed = false;
        }
    }

    protected function validateLinkedIn($content): void
    {
        // LinkedIn minimum length
        if (strlen($content) < 50) {
            $this->message = 'LinkedIn posts should be at least 50 characters';
            $this->passed = false;
        }

        // LinkedIn maximum length
        if (strlen($content) > 3000) {
            $this->message = 'LinkedIn posts cannot exceed 3000 characters';
            $this->passed = false;
        }
    }

    public function message(): string
    {
        return $this->message;
    }
}
