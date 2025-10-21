<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::latest()->paginate(10);
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:tags']);
        Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);
        return redirect()->route('admin.tags.index')->with('success', 'Tạo từ khoá thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        // Not typically used for tags, can redirect to edit
        return redirect()->route('admin.tags.edit', $tag);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $request->validate(['name' => 'required|string|max:255|unique:tags,name,' . $tag->id]);
        $tag->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);
        return redirect()->route('admin.tags.index')->with('success', 'Cập nhật từ khoá thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return back()->with('success', 'Xóa từ khoá thành công.');
    }
}