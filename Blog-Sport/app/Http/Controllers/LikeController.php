<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function likeBlog($blogId)
    {
        $like = new Like();
        $like->user_id = Auth::id();
        $like->blog_id = $blogId;
        $like->save();
        $this->addLikeToBlog($blogId);

        return redirect()->back();
    }
    public function dislikeBlog($blogId)
    {
        Like::where("blog_id",$blogId)->where('user_id',Auth::id())->delete();
        $this->subLikeToBlog($blogId);

        return redirect()->back();
    }
    public function addLikeToBlog($blogId)
    {
        $blog = Blog::findOrFail($blogId);
        $blog->like += 1;
        $blog->save();
    }
    public function subLikeToBlog($blogId)
    {
        $blog = Blog::findOrFail($blogId);
        $blog->like -= 1;
        $blog->save();
    }
}
