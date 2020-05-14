<?php


namespace App\Repositories;


use App\Models\Post;

class PostRepository
{
    protected $post, $tagRepository;

    public function __construct(Post $post, TagRepository $tagRepository)
    {
        $this->post = $post;
        $this->tagRepository = $tagRepository;
    }

    public function create($data)
    {
        return $this->post->create($data);
    }

    public function update($id, $data)
    {
        $post = $this->find($id);
        $post->update($data);
        $post->tags()->sync($data['tags']);
    }

    public function all()
    {
        return $this->post->with(['user', 'tags'])->latest()->paginate(12);
    }

    public function search($query)
    {
        return $this->post->with(['user', 'tags'])
            ->where('title', 'like', "%$query%")
            ->latest()
            ->paginate(12);
    }

    public function getPostsByTag($request)
    {
        $tag = $this->tagRepository->find($request->tagId);
        if ($tag) {
            return $request->search ? $tag->posts()->with(['user', 'tags'])
                ->where('title', 'like', "%$request->search%")
                ->latest()
                ->paginate(12) :
                $tag->posts()->with(['user', 'tags'])->latest()->paginate(12);

        } else {
            return ['data' => []];
        }
    }

    public function getByUserId($userId)
    {
        return $this->post->whereUserId($userId)->latest()->paginate(12);
    }

    public function searchUserPosts($userId, $query)
    {
        return $this->post->whereUserId($userId)
            ->where('title', 'like', "%$query%")
            ->latest()
            ->paginate(12);
    }

    public function find($id)
    {
        return $this->post->with(['user', 'tags'])->find($id);
    }

    public function destroy($id)
    {
        return $this->post->destroy($id);
    }

}
