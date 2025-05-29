<?php

namespace App\Http\Controllers;

use App\Architecture\Repositories\Interfaces\IPlatformRepository;
use App\Architecture\Repositories\Interfaces\IPostRepository;
use App\Http\Requests\PostFilterRequest;
use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        private readonly IPlatformRepository $platformRepository,
        private readonly IPostRepository $postRepository,
    )
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param PostFilterRequest $request
     * @return Renderable
     */
    public function index(PostFilterRequest $request): Renderable
    {
        //dd($request->all());
        // status - platform - date
        $platforms = $this->platformRepository->all();
        $posts = $this->postRepository->paginateByUser(auth()->id(), 5, $request->safe()->toArray());
        $scheduledPosts = $this->postRepository->getScheduled();
        return view('home', compact('platforms', 'posts', 'scheduledPosts'));
    }
}
