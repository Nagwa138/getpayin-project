<?php

namespace App\Http\Controllers\API;

use App\Architecture\Services\Interfaces\IPlatformService;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Platform\PlatformToggleRequest;
use Illuminate\Http\JsonResponse;

class PlatformController extends Controller
{
    /**
     * @param IPlatformService $platformService
     */
    public function __construct(
        private readonly IPlatformService $platformService
    )
    {}

    /**
     * @param PlatformToggleRequest $request
     * @return JsonResponse
     */
    public function toggle(PlatformToggleRequest $request): JsonResponse
    {
        return $this->platformService->toggle($request->getPlatformId(), $request->getIsActive());
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->platformService->list();
    }
}
