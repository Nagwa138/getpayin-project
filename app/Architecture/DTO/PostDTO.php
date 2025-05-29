<?php

namespace App\Architecture\DTO;

use Illuminate\Support\Carbon;

class PostDTO extends DataTransferObject
{
    public string $title;
    public string $content;
    public ?string $image_url;
    public ?string $status;
    public string $scheduled_time;
    public string $user_id;
    public array $platforms;

    static public function fromRequest(array $request): self
    {
        return new self(
            [
                'title' => $request['title'],
                'content' => $request['content'],
                'image_url' => request()->hasFile('image') ? uploadFile(request()->file('image'), 'posts') : null,
                'scheduled_time' => $request['scheduled_time'],
                'user_id' => auth()->id(),
                'status' => $request['status'] ?? 'scheduled',
                'platforms' => $request['platforms'] ?? null,
            ]
        );
    }
}
