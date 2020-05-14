<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Repositories\TagRepository;
use App\Services\Constants;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    protected $postService, $tagRepository;

    public function __construct(PostService $postService, TagRepository $tagRepository)
    {
        $this->postService = $postService;
        $this->tagRepository = $tagRepository;
        $this->middleware('isValidTagId', ['only' => ['index']]);
        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('owner', ['only' => ['edit', 'update', 'destroy']]);
    }

    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $posts = $this->postService->getPosts($request);
            return response()->json($posts);
        }
        $tag = isset($request->tagId) ? $this->tagRepository->find($request->get('tagId')) : null;
        return view('posts.index', compact('tag'));
    }

    public function userPosts(Request $request)
    {
        if ($request->wantsJson()) {
            $posts = $this->postService->getByAuthUser($request);
            return response()->json($posts);
        }
        return view('posts.user-posts');
    }

    public function create()
    {
        $tags = $this->tagRepository->all();
        return view('posts.create', compact('tags'));
    }

    public function store(PostRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->postService->store($request);
            DB::commit();
            return redirect()->route('posts.user')->with(['message' => 'Post created successfully!', 'alert-class' => 'alert-success']);
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with(['message' => Constants::WENT_WRONG, 'alert-class' => 'alert-danger']);
        }
    }

    public function show($id)
    {
        $post = $this->postService->find($id);
        if (!$post)
            abort(404);
        return view('posts.show', compact('post'));
    }

    public function edit($id)
    {
        $post = $this->postService->find($id);
        if (!$post)
            abort(404);
        $tags = $this->tagRepository->all();
        return view('posts.edit', compact('tags', 'post'));
    }

    public function update(PostRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $this->postService->update($request, $id);
            DB::commit();
            return redirect()->back()->with(['message' => 'Post updated successfully!', 'alert-class' => 'alert-success']);
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with(['message' => Constants::WENT_WRONG, 'alert-class' => 'alert-danger']);
        }
    }

    public function destroy($id)
    {
        try {
            $this->postService->destroy($id);
            return response()->json(["message" => "Post has been deleted."]);
        } catch (\Exception $exception) {
            return response()->json(["message" => Constants::WENT_WRONG], 400);
        }
    }
}
