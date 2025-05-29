<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'image_url',
        'scheduled_time',
        'status',
        'user_id'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'scheduled_time' => 'datetime',
        ];
    }

    /**
     * Post belongs to one user
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Post has many platforms
     */
    public function platforms()
    {
        return $this->belongsToMany(Platform::class, 'platform_post')
            ->withPivot(['platform_status'])
            ->withTimestamps();
    }
}
