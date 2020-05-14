<?php


namespace App\Repositories;


use App\Models\Tag;

class TagRepository
{
    protected $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function find($id)
    {
        return $this->tag->find($id);
    }

    public function all()
    {
        return $this->tag->all();
    }

}
