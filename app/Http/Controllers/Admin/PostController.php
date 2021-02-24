<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Notifications\AuthorPostApproved;
use App\Notifications\NewPostNotify;
use App\Repository\CategoriesRepository;
use App\Repository\PostRepositoty;
use App\Repository\TagRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Models\Subscribe;



class PostController extends Controller
{
    protected $postRepositoty,$categoriesRepository,$tagRepository;

   public  function  __construct(PostRepositoty $postRepositoty,CategoriesRepository $categoriesRepository,TagRepository $tagRepository)
   {
       $this->postRepositoty=$postRepositoty;
       $this->categoriesRepository=$categoriesRepository;
       $this->tagRepository=$tagRepository;
   }
    public function index()
    {
        $posts=$this->postRepositoty->getPostOfIndex();
        return view('admin.post.index',compact('posts'));
    }


    public function create()
    {
        $categories =$this->categoriesRepository->getCategoryOfIndex();
        $tags=$this->tagRepository->getTagOfIndex();
        return view('admin.post.create',compact('categories','tags'));
    }

    public function store(PostRequest $request)
    {
        try {
            $post=$this->postRepositoty->PostStore($request);
            $subscribers = Subscribe::all();
            foreach ($subscribers as $subscriber)
            {
                Notification::route('mail',$subscriber->email)
                    ->notify(new NewPostNotify($post));
            }
            $this->setSuccessMessage('Post Successfully Saved');
            return redirect()->route('admin.post.index');
        } catch (Exception $e) {
            $this->setErrorMessage($e->getMessage());
        }
    }
    public  function show($id)
    {
        $categories =$this->categoriesRepository->getCategoryOfIndex();
        $tags=$this->tagRepository->getTagOfIndex();
        $post=$this->postRepositoty->getPostId($id);
        return view('admin.post.show',compact('post','categories','tags'));
    }

    public function edit($id)
    {
        $post=$this->postRepositoty->getPostId($id);
        $categories =$this->categoriesRepository->getCategoryOfIndex();
        $tags=$this->tagRepository->getTagOfIndex();
        return  view('admin.post.edit',compact('post','categories','tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id

     */
    public function update(Request $request, $id)
    {
        try {
            $this->postRepositoty->postUpdate($request,$id);
            $this->setSuccessMessage('Post Successfully Saved');
            return redirect()->route('admin.post.index');
        } catch (Exception $e) {
            $this->setErrorMessage($e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $this->postRepositoty->postDelete($id);
            $this->setSuccessMessage('Tag Successfully Delete');
            return redirect()->route('admin.post.index');
        } catch (Exception $e) {
            $this->setErrorMessage($e->getMessage());
        }
    }
    public  function approval($id)
    {
        try {
            $post=$this->postRepositoty->postApproval($id);
            $this->setSuccessMessage('Tag Successfully approve');
            $post->user->notify(new AuthorPostApproved($post));

            $subscribers = Subscribe::all();
            foreach ($subscribers as $subscriber)
            {
                Notification::route('mail',$subscriber->email)
                    ->notify(new NewPostNotify($post));
            }
            return redirect()->route('admin.post.index');
        } catch (Exception $e) {
            $this->setErrorMessage($e->getMessage());
        }
    }
}
