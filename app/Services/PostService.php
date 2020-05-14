<?php


namespace App\Services;


use App\Repositories\PostRepository;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostService
{
    protected $postRepository, $tagRepository;

    public function __construct(PostRepository $postRepository, TagRepository $tagRepository)
    {
        $this->postRepository = $postRepository;
        $this->tagRepository = $tagRepository;
    }

    public function getPosts(Request $request)
    {
        if ($request->tagId) {
            return $this->postRepository->getPostsByTag($request);
        }
        return $request->search ?
            $this->search($request->search) :
            $this->all();
    }

    public function getByAuthUser($request)
    {
        return $request->search ? $this->postRepository->searchUserPosts(Auth::id(), $request->search) :
            $this->postRepository->getByUserId(Auth::id());
    }

    public function all()
    {
        return $this->postRepository->all();
    }

    public function find($id)
    {
        return $this->postRepository->find($id);
    }

    public function search($query)
    {
        return $this->postRepository->search($query);
    }

    public function store(Request $request)
    {
        $request['user_id'] = Auth::id();
        $post = $this->postRepository->create($request->all());
        $post->tags()->sync($request->tags);
    }

    public function update(Request $request, $id)
    {
        $this->postRepository->update($id, $request->all());
    }

    public function destroy($id)
    {
       return $this->postRepository->destroy($id);
    }
}
