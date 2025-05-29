<?php

namespace App\Architecture\Services\Interfaces;

use Illuminate\Http\JsonResponse;

interface IPlatformService
{
    /**
     * @return JsonResponse
     */
    public function list(): JsonResponse;

    /**
     * @param int $id
     * @param bool $is_active
     * @return JsonResponse
     */
    public function toggle(int $id, bool $is_active): JsonResponse;
}
