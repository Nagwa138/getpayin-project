<?php

namespace App\Http\Controllers;

use App\Architecture\DTO\PostDTO;
use App\Architecture\Repositories\Interfaces\IPlatformRepository;
use App\Architecture\Services\Interfaces\IPlatformService;
use App\Architecture\Services\Interfaces\IPostService;
use App\Http\Requests\API\Platform\PlatformToggleRequest;
use App\Http\Requests\API\Post\PostStoreRequest;
use App\Http\Resources\PlatformResource;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use SweetAlert2\Laravel\Swal;

class PostController extends Controller
{
    /**
     * @param IPostService $postService
     * @param IPlatformRepository $platformRepository
     * @param IPlatformService $platformService
     */
    public function __construct(
        private readonly IPostService        $postService,
        private readonly IPlatformRepository $platformRepository,
        private readonly IPlatformService    $platformService,
    )
    {}

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Factory|Application|View
    {
        $maxCharacterLimit = 2200;
        $platforms = $this->platformRepository->all();
        $platformRestrictions = $this->platformRepository->userNotAllowedPlatforms(auth()->id());
        return view('posts.create', compact('maxCharacterLimit', 'platforms', 'platformRestrictions'));
    }

    /**
     * View setting
     * @return Factory|Application|View
     */
    public function setting(): Factory|Application|View
    {
        $platforms = PlatformResource::collection($this->platformRepository->all())->toArray(request());
        return view('settings.platforms', compact('platforms'));
    }

    /**
     * Toggle platform status for a user
     * @param PlatformToggleRequest $request
     * @return RedirectResponse
     */
    public function togglePlatform(PlatformToggleRequest $request): RedirectResponse
    {
        $response = $this->platformService->toggle($request->getPlatformId(), $request->getIsActive());

        if ($response->getStatusCode() == 200) {
            Swal::toastSuccess([
                'title' => $request->getIsActive() ? 'Platform activated successfully' : 'Platform deactivated successfully',
            ]);
        } else {
            Swal::toastError([
                'title' => 'Request can not be handled in certain time!',
            ]);
        }

        return redirect()->route('settings.platforms');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request): RedirectResponse
    {
        $response = $this->postService->create(array_filter((array)PostDTO::fromRequest($request->safe()->toArray())));

        if ($response->getStatusCode() == 201) {
            Swal::toastSuccess([
                'title' => 'Post scheduled successfully',
            ]);
        } else {
            Swal::toastError([
                'title' => 'Request can not be handled in certain time! ',
            ]);
        }

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     */
    public function listScheduled(): JsonResponse
    {
        return $this->postService->listByUserCalender();
    }
}
