<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostCategoryController extends Controller
{
    /**
     * Hiển thị danh sách các danh mục bài viết.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $sort = $request->input('sort', 'newest');

        $query = PostCategory::query()->withCount('posts');

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
            case 'posts_desc':
                $query->orderBy('posts_count', 'desc');
                break;
            default:
                $query->latest('created_at');
        }

        $categories = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => PostCategory::count(),
            'created_this_month' => PostCategory::whereBetween('created_at', [now()->startOfMonth(), now()])->count(),
            'created_this_week' => PostCategory::whereBetween('created_at', [now()->startOfWeek(), now()])->count(),
            'last_created_at' => PostCategory::latest('created_at')->value('created_at'),
        ];

        $recentCategories = PostCategory::latest('created_at')->take(6)->get();

        $topCategories = PostCategory::withCount('posts')
            ->orderByDesc('posts_count')
            ->take(5)
            ->get();

        return view('admin.post_categories.index', [
            'categories' => $categories,
            'stats' => $stats,
            'filters' => [
                'search' => $search,
                'sort' => $sort,
            ],
            'recentCategories' => $recentCategories,
            'topCategories' => $topCategories,
        ]);
    }

    /**
     * Hiển thị form tạo danh mục mới.
     */
    public function create()
    {
        return view('admin.post_categories.create', [
            'category' => new PostCategory(),
        ]);
    }

    /**
     * Lưu trữ danh mục mới vào cơ sở dữ liệu.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:post_categories,name',
            'slug' => 'nullable|string|max:255|unique:post_categories,slug',
        ]);

        // Tạo slug nếu người dùng không nhập
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        PostCategory::create($validated);

        return redirect()->route('admin.post_categories.index')->with('success', 'Danh mục bài viết đã được tạo thành công.');
    }

    /**
     * Hiển thị form chỉnh sửa danh mục.
     */
    public function edit(PostCategory $postCategory)
    {
        return view('admin.post_categories.edit', [
            'category' => $postCategory,
        ]);
    }

    /**
     * Cập nhật danh mục trong cơ sở dữ liệu.
     */
    public function update(Request $request, PostCategory $postCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:post_categories,name,' . $postCategory->id,
            'slug' => 'nullable|string|max:255|unique:post_categories,slug,' . $postCategory->id,
        ]);

        // Tạo slug nếu người dùng không nhập hoặc muốn cập nhật
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $postCategory->update($validated);

        return redirect()->route('admin.post_categories.index')->with('success', 'Danh mục bài viết đã được cập nhật thành công.');
    }

    /**
     * Xóa danh mục khỏi cơ sở dữ liệu.
     */
    public function destroy(PostCategory $postCategory)
    {
        // Bạn có thể thêm logic kiểm tra xem có bài viết nào đang sử dụng danh mục này không 
        // trước khi cho phép xóa.
        if ($postCategory->posts()->exists()) {
            return redirect()->route('admin.post_categories.index')->with('error', 'Không thể xóa danh mục này vì nó vẫn còn bài viết liên quan.');
        }

        $postCategory->delete();

        return redirect()->route('admin.post_categories.index')->with('success', 'Danh mục bài viết đã được xóa thành công.');
    }
}