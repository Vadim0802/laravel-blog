<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Models\Tag;
use App\Services\TagService;

class AdminManageTagsController extends Controller
{
    private TagService $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function index()
    {
        $tags = $this->tagService->getTagsWithPaginate(10);

        return view('admin.manage_tags', compact('tags'));
    }

    public function store(StoreTagRequest $request)
    {
        $this->tagService->storeNewTag($request->name);

        return to_route('admin_manage_tags_index')->with('success', 'Tag created successfully!');
    }

    public function destroy(Tag $tag)
    {
        $this->tagService->deleteTag($tag);

        return to_route('admin_manage_tags_index')->with('success', 'Tag deleted successfully!');
    }
}
