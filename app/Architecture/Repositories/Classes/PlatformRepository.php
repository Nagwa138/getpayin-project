<?php

namespace App\Architecture\Repositories\Classes;

use App\Architecture\Repositories\AbstractRepository;
use App\Architecture\Repositories\Interfaces\IPlatformRepository;
use App\Models\Platform;
use App\Models\User;

class PlatformRepository extends AbstractRepository implements IPlatformRepository
{
    /**
     * @param int $id
     * @return Platform
     */
    public function find(int $id): Platform
    {
        return $this->first(['id' => $id]);
    }

    /**
     * @param array $ids
     * @return array
     */
    public function getTypesByIds(array $ids): array
    {
        return $this->prepareQuery()->whereIn('id', $ids)->pluck('type')->toArray();
    }

    public function userNotAllowedPlatforms(int $userId): array
    {
        return $this->prepareQuery()->whereDoesntHave('users', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->pluck('platforms.id', 'platforms.name')->toArray();
    }
}
