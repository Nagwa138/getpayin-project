<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PlatformAllowedRule implements Rule
{
    /**
     * @var string
     */
    protected string $message = 'Please choose platforms in your allowed platforms.';

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes( $attribute,  $value): bool
    {
        return auth()->user()->activePlatforms()->whereIn('platform_id', [$value])->exists();
    }

    public function message(): string
    {
        return $this->message;
    }
}
