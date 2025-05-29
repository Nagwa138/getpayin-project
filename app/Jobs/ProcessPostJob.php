<?php

namespace App\Jobs;

use App\Architecture\Repositories\Interfaces\IPostRepository;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessPostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private IPostRepository $postRepository;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly Post $post,
    )
    {
        $this->postRepository = app(IPostRepository::class);
        $this->handle();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $this->postRepository->update(['id' => $this->post->id], ['status' => 'published']);
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage());
        }
    }
}
