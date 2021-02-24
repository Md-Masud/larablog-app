<?php


namespace App\Repository;


use App\Models\Post;
use App\Repository\Image\PostImage;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;


class PostRepositoty extends  PostImage
{

    public function getPostOfIndex()
    {
        $posts=Post::latest()->get();
        return $posts ;
    }
    public function PostStore($request)
    {

        $post = new Post();
        $this->imageStore($request);
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->slug = $this->slug;
        $post->image = $this->imagename;
        $post->body = $request->body;
        if(isset($request->status))
        {
            $post->status = true;
        }else {
            $post->status = false;
        }
        $post->is_approved = true;
        $post->save();
        $post->categories()->attach($request->categories);
        $post->tags()->attach($request->tags);

        return $post;
    }
    public  function  getPostId($id)
    {
        $post=Post::find($id);
        return $post;
    }

    public  function  postUpdate($request ,$id)
    {
        $post=Post::find($id);
        $this->postStore($request);
        return $post;

    }
    public function  postDelete($id)
    {
        $post=$this->getPostId($id);
        $this->imageDelete($post);
        return $post->delete();
    }
    public  function  postApproval($id)
    {

        $post = $this->getPostId($id);
        if ($post->is_approved == false)
        {
            $post->is_approved = true;
            $post->save();

        } else {
            Toastr::info('This Post is already approved','Info');
        }

    }
}
