<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $postCategories = PostCategory::latest()->paginate(10);
        return view('admin.post_categories.index', compact('postCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.post_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:post_categories']);
        PostCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);
        return redirect()->route('admin.post-categories.index')->with('success', 'Tạo danh mục bài viết thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PostCategory $postCategory)
    {
        return view('admin.post_categories.edit', compact('postCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PostCategory $postCategory)
    {
        $request->validate(['name' => 'required|string|max:255|unique:post_categories,name,' . $postCategory->id]);
        $postCategory->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);
        return redirect()->route('admin.post-categories.index')->with('success', 'Cập nhật danh mục bài viết thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PostCategory $postCategory)
    {
        $postCategory->delete();
        return back()->with('success', 'Xóa danh mục bài viết thành công.');
    }
}
