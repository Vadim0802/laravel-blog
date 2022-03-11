<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Models\Tag;

class AdminManageTagsController extends Controller
{
    public function index()
    {
        $tags = Tag::query()->paginate(10);

        return view('admin.manage_tags', [
            'tags' => $tags
        ]);
    }

    public function store(StoreTagRequest $request)
    {
        Tag::query()->create($request->validated());

        return to_route('admin_manage_tags_index')->with('success', 'Tag created successfully!');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return to_route('admin_manage_tags_index')->with('success', 'Tag deleted successfully!');
    }
}
