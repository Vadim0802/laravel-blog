<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Models\Tag;
use App\Services\TagService;

class AdminManageTagsController extends Controller
{
    public function index(TagService $tagService)
    {
        $tags = $tagService->getTagsWithPaginate(10);

        return view('admin.manage_tags', compact('tags'));
    }

    public function store(StoreTagRequest $request, TagService $tagService)
    {
        $tagService->storeNewTag($request->name);

        return to_route('admin_manage_tags_index')->with('success', 'Tag created successfully!');
    }

    public function destroy(Tag $tag, TagService $tagService)
    {
        $tagService->deleteTag($tag);

        return to_route('admin_manage_tags_index')->with('success', 'Tag deleted successfully!');
    }
}
