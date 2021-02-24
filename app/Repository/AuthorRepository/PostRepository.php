<?php

namespace App\Repository\AuthorRepository;
use App\Models\Post;
use App\Repository\Image\PostImage;
use Illuminate\Support\Facades\Auth;

class PostRepository extends  PostImage
{
  public function getIndex()
  {
      $post=Auth::user()->posts()->latest()->get();
      return $post;
  }

  public function postStore($request)
  {

      $post= new Post();
      $this->imageStore($request);
      $this->disk='post/';
      $post->user_id = Auth::id();
      $post->title = $request->title;
      $post->slug = $this->slug;
      $post->image = $this->imagename;
      $post->body = $request->body;
      if(isset($request->status))
      {
          $post->status= true;
      }
      else{
          $post->status =false;
      }
      $post->is_approved = false;
      $post->save();
      $post->categories()->attach($request->categories);
      $post->tags()->attach($request->tags);
      return $post;
  }
  public  function getPostId($id)
  {
      $post=Post::find($id);
      return $post;
  }
  public function  postUpdate($request,$id)
  {
      $post=Post::find($id);
      $this->imageStore($request);

      $post->user_id = Auth::id();
      $post->title = $request->title;
      $post->slug = $this->slug;
      $post->image = $this->imagename;
      $post->body = $request->body;
      if(isset($request->status))
      {
          $post->status=true;
      }
      else
      {
          $post->status=false;
      }
      $post->is_approved = true;
      $post->save();
      $post->categories()->attach($request->categories);
      $post->tags()->attach($request->tags);
      return $post;
  }
  public function postDelete($id)
  {
      $post=$this->getPostId($id);
      $this->imageDelete($post);
      return $post->delete();
  }

}
