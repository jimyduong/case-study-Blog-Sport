<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    public function index()
    {
        $blogs = Blog::orderby('created_at', 'desc')->paginate(3);
        $category = Category::all();
        return view('customer.list', compact('blogs', 'category'));
    }

    public function showByView()
    {
        $blogs = Blog::orderby('view', 'desc')->paginate(3);
        $category = Category::all();
        return view('customer.list', compact('blogs', 'category'));
    }

    public function showByLike()
    {
        $blogs = Blog::orderby('like', 'desc')->paginate(3);
        $category = Category::all();
        return view('customer.list', compact('blogs', 'category'));
    }

    public function view($id)
    {
        $blogKey = 'post_' . $id;
        if (!Session::has($blogKey)) {
            Blog::where('id', $id)->increment('view');
            Session::put($blogKey, 1);
//            Session::forget($blogKey);
        }
        $blog = Blog::findOrFail($id);
        $status = $this->checkStatus($id);
        return view('customer.view', compact('blog','status'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        if (!$keyword) {
            return redirect()->route('customer.index');
        }
        $blogs = Blog::where('post_title', 'LIKE', '%' . $keyword . '%')
            ->paginate(5);
        $category = Category::all();
        return view('customer.list', compact('blogs', 'category'));
    }

    public function filterByCategory(Request $request)
    {
        $idCategory = $request->input('category_id');
        $categoryFilter = Category::findOrFail($idCategory);
        $blogs = Blog::where('category_id', $categoryFilter->id)->paginate(3);
        $totalPostFilter = count($blogs);
        $category = Category::all();

        return view('customer.list', compact('blogs', 'totalPostFilter', 'category', 'categoryFilter'));
    }

    public function checkStatus($blogId)
    {
        $blogs = Blog::findOrFail($blogId);
        $likesInBlog = $blogs->likes;
        if (count($likesInBlog) == 0) {
            return false;
        } else {
            foreach ($likesInBlog as $like) {
                if ($like->user->id === Auth::id()) {
                    return true;
                }
            }
            return false;
        }
    }
}
