<?php

namespace App\Architecture\Services\Classes;

use App\Architecture\Repositories\Interfaces\IPlatformRepository;
use App\Architecture\Responder\IApiHttpResponder;
use App\Architecture\Services\Interfaces\IPlatformService;
use App\Http\Resources\PlatformResource;
use App\Models\Platform;
use Illuminate\Http\JsonResponse;

class PlatformService implements IPlatformService
{
    /**
     * @param IPlatformRepository $platformRepository
     * @param IApiHttpResponder $apiHttpResponder
     */
    public function __construct(
        private readonly IPlatformRepository $platformRepository,
        private readonly IApiHttpResponder   $apiHttpResponder
    )
    {}

    /**
     * List Platforms
     *
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        return $this->apiHttpResponder->sendSuccess(PlatformResource::collection($this->platformRepository->all())->toArray(request()));
    }

    /**
     * Toggle platform status
     *
     * @param int $id
     * @param bool $is_active
     * @return JsonResponse
     */
    public function toggle(int $id, bool $is_active): JsonResponse
    {
        try {
            auth()->user()->platforms()->syncWithoutDetaching([$id => ['is_active' => $is_active]]);
            $post = $this->platformRepository->find($id);
            return $this->apiHttpResponder->sendSuccess([
                'message' => 'Toggled successfully',
                'platform' => PlatformResource::make($post)->toArray(request()),
            ]);
        } catch (\Throwable $exception) {
            return $this->apiHttpResponder->sendError($exception->getMessage(), $exception->getCode());
        }
    }
}
