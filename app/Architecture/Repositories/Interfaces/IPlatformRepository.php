<?php

namespace App\Architecture\Repositories\Interfaces;

use App\Models\Platform;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface IPlatformRepository
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param int $id
     * @return Platform
     */
    public function find(int $id): Platform;

    /**
     * Get Types of array of platforms by its IDs
     *
     * @param array $ids
     * @return array
     */
    public function getTypesByIds(array $ids): array;

    public function userNotAllowedPlatforms(int $userId): array;
}
