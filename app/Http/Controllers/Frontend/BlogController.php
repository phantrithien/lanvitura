<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class BlogController extends Controller
{
    /**
     * Hiển thị trang danh sách bài viết.
     */
    public function index()
    {
        // Giả sử bạn đã tạo Model, Migration, Seeder cho Post
        $posts = Post::latest()->paginate(9);
        
        // Giả sử bạn đã tạo view này ở câu trước
        return view('frontend.blog.index', compact('posts'));
    }
    /**
     * Hiển thị trang chi tiết bài viết.
     */
    public function show(Post $post)
    {
        // Giả sử bạn đã tạo view này ở câu trước
        return view('frontend.blog.show', compact('post'));
    }
}