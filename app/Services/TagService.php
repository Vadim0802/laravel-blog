<?php

namespace App\Services;

use App\Models\Tag;

class TagService
{
    public function getTags()
    {
        $tags = Tag::all();

        return $tags;
    }

    public function getTagsWithPaginate(int $paginate)
    {
        $tags = Tag::query()->paginate($paginate);

        return $tags;
    }

    public function storeNewTag(string $name)
    {
        $tag = Tag::query()->create(['name' => $name]);

        return $tag;
    }

    public function deleteTag(Tag $tag)
    {
        return $tag->delete();
    }
}
