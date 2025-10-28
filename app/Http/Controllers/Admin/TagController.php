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
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $sort = $request->input('sort', 'newest');

        $query = Tag::query();

        if ($search !== '') {
            $query->where(function ($inner) use ($search) {
                $inner->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        switch ($sort) {
            case 'oldest':
                $query->oldest('created_at');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->latest('created_at');
        }

        $tags = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => Tag::count(),
            'created_this_month' => Tag::whereBetween('created_at', [now()->startOfMonth(), now()])->count(),
            'created_this_week' => Tag::whereBetween('created_at', [now()->startOfWeek(), now()])->count(),
            'last_created_at' => Tag::latest('created_at')->value('created_at'),
        ];

        $recentTags = Tag::latest('created_at')->take(6)->get();

        $longestTags = Tag::select(['id', 'name', 'slug'])
            ->selectRaw('CHAR_LENGTH(name) as name_length')
            ->orderByDesc('name_length')
            ->take(5)
            ->get();

        return view('admin.tags.index', [
            'tags' => $tags,
            'stats' => $stats,
            'filters' => [
                'search' => $search,
                'sort' => $sort,
            ],
            'recentTags' => $recentTags,
            'longestTags' => $longestTags,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tags.create', [
            'tag' => new Tag(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
            'slug' => 'nullable|string|max:255|unique:tags,slug',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        Tag::create($validated);

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
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
            'slug' => 'nullable|string|max:255|unique:tags,slug,' . $tag->id,
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $tag->update($validated);

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