<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $categoryId = $request->input('category_id');
        $stock = $request->input('stock', 'all');
        $sort = $request->input('sort', 'newest');

        $query = Product::query()
            ->with(['category', 'images'])
            ->withSum('orderDetails as total_sold', 'quantity');

        if ($search !== '') {
            $query->where(function ($inner) use ($search) {
                $inner->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        if ($stock === 'in_stock') {
            $query->where('stock_quantity', '>', 10);
        } elseif ($stock === 'low_stock') {
            $query->whereBetween('stock_quantity', [1, 10]);
        } elseif ($stock === 'out_of_stock') {
            $query->where('stock_quantity', '<=', 0);
        }

        switch ($sort) {
            case 'oldest':
                $query->oldest('created_at');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'stock_asc':
                $query->orderBy('stock_quantity', 'asc');
                break;
            case 'stock_desc':
                $query->orderBy('stock_quantity', 'desc');
                break;
            case 'top_selling':
                $query->orderByDesc('total_sold')->orderByDesc('stock_quantity');
                break;
            default:
                $query->latest('created_at');
        }

        $products = $query->paginate(12)->withQueryString();

        $stats = [
            'total' => Product::count(),
            'in_stock' => Product::where('stock_quantity', '>', 10)->count(),
            'low_stock' => Product::whereBetween('stock_quantity', [1, 10])->count(),
            'out_of_stock' => Product::where('stock_quantity', '<=', 0)->count(),
            'avg_price' => Product::avg('price'),
            'last_updated_at' => Product::latest('updated_at')->value('updated_at'),
        ];

        $topSellingProducts = Product::with(['category', 'images'])
            ->withSum('orderDetails as total_sold', 'quantity')
            ->whereHas('orderDetails')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        $lowStockProducts = Product::with('category')
            ->whereBetween('stock_quantity', [1, 10])
            ->orderBy('stock_quantity')
            ->take(5)
            ->get();

        $categories = Category::orderBy('name')->get(['id', 'name']);

        return view('admin.products.index', [
            'products' => $products,
            'categories' => $categories,
            'stats' => $stats,
            'filters' => [
                'search' => $search,
                'category_id' => $categoryId,
                'stock' => $stock,
                'sort' => $sort,
            ],
            'topSellingProducts' => $topSellingProducts,
            'lowStockProducts' => $lowStockProducts,
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', [
            'categories' => $categories,
            'product' => new Product(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'size_count' => 'nullable|integer|min:1|max:4',
            'brand' => 'nullable|string|max:120',
            'color' => 'nullable|string|max:120',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10048'
        ]);

        $sizeCount = max(1, min(4, (int) $request->input('size_count', 1)));
        $sizeTokens = implode(',', array_map('strval', range(1, $sizeCount)));

        // Để Model tự sinh slug duy nhất trong hook saving (xử lý trùng lặp)
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'category_id' => $request->category_id,
            'brand' => $request->brand,
            'color' => $request->color,
            'size' => $sizeTokens,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imagefile) {
                $path = $imagefile->store('images/products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'size_count' => 'nullable|integer|min:1|max:4',
            'brand' => 'nullable|string|max:120',
            'color' => 'nullable|string|max:120',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10048'
        ]);

        $sizeCount = max(1, min(4, (int) $request->input('size_count', 1)));
        $sizeTokens = implode(',', array_map('strval', range(1, $sizeCount)));

        // Không cập nhật slug để tránh va chạm unique và giữ SEO stable
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'category_id' => $request->category_id,
            'brand' => $request->brand,
            'color' => $request->color,
            'size' => $sizeTokens,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imagefile) {
                $path = $imagefile->store('images/products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path
                ]);
            }
        }
        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công!');
    }
}