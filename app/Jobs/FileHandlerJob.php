<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileHandlerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Filesystem
     */
    private static Filesystem $fileDisk;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        self::$fileDisk = Storage::disk('public');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }

    public static function uploadFile($file, $path = ''): string
    {
        $name = time() . Str::random(rand(5, 10)) . '.' . $file->getClientOriginalExtension();

        if (self::$fileDisk->exists($path)) self::$fileDisk->makeDirectory($path);

        return $file->storeAs($path, $name, 'public');
    }

    /**
     * Remove file from storage
     *
     * @param string $file
     * @return void
     */
    public static function removeFile(string $file): void
    {
        if ($file && self::$fileDisk->exists($file)) self::$fileDisk->delete($file);
    }
}
