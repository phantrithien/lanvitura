<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Thêm Str

class CategoryController extends Controller
{
    /**
     * Hiển thị danh sách các danh mục (Sản phẩm).
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $state = $request->input('state', 'all');

        $query = Category::query()->withCount('products');

        if ($search !== '') {
            $query->where(function ($innerQuery) use ($search) {
                $innerQuery->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($state === 'with_products') {
            $query->whereHas('products');
        } elseif ($state === 'empty') {
            $query->whereDoesntHave('products');
        }

        $categories = $query->latest('updated_at')->paginate(12)->withQueryString();

        $latestUpdatedCategory = Category::latest('updated_at')->first();

        $stats = [
            'total' => Category::count(),
            'with_products' => Category::has('products')->count(),
            'empty' => Category::doesntHave('products')->count(),
            'last_updated_at' => $latestUpdatedCategory?->updated_at,
        ];

        $topCategories = Category::withCount('products')
            ->whereHas('products')
            ->orderByDesc('products_count')
            ->take(5)
            ->get();

        $recentCategories = Category::latest()
            ->take(5)
            ->get();

        return view('admin.categories.index', [
            'categories' => $categories,
            'stats' => $stats,
            'topCategories' => $topCategories,
            'recentCategories' => $recentCategories,
            'search' => $search,
            'state' => $state,
        ]);
    }

    /**
     * Hiển thị form tạo danh mục mới.
     */
    public function create()
    {
        // Trả về view mới
        return view('admin.categories.create');
    }

    /**
     * Lưu trữ danh mục mới vào cơ sở dữ liệu.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Danh mục sản phẩm đã được tạo.');
    }

    /**
     * Hiển thị form chỉnh sửa danh mục.
     */
    public function edit(Category $category)
    {
        $category->loadCount('products');

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Cập nhật danh mục trong cơ sở dữ liệu.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Danh mục sản phẩm đã được cập nhật.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')->with('error', 'Không thể xóa danh mục này vì vẫn còn sản phẩm.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Danh mục sản phẩm đã được xóa.');
    }
}