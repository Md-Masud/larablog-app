<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\User;
use App\Notifications\NewAuthorPost;
use App\Repository\AuthorRepository\PostRepository;
use App\Repository\CategoriesRepository;
use App\Repository\TagRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;



class PostController extends Controller
{
    private  $postRepository, $tagRepository,$categoriesRepository;


    public function __construct(PostRepository $postRepository,CategoriesRepository $categoriesRepository ,TagRepository $tagRepository)
    {
        $this->postRepository=$postRepository;
        $this->tagRepository=$tagRepository;
        $this->categoriesRepository=$categoriesRepository;

    }


    public function index()
    {
        $posts=$this->postRepository->getIndex();
        return  view('author.post.index',compact('posts'));
    }

    public function create()
    {
        $tags=$this->tagRepository->getTagOfIndex();
        $categories=$this->categoriesRepository->getCategoryOfIndex();
        return view('author.post.create',compact('tags','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
    public function store(PostRequest $request)
    {
        try {
            $post=$this->postRepository->postStore($request);
            $users = User::where('role_id','1')->get();
            Notification::send($users, new NewAuthorPost($post));
            $this->setSuccessMessage('Post Successfully Saved');
            return redirect()->route('author.post.index');

        }
        catch (Exception $e)
        {
            $this->setErrorMessage($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     */
    public function show($id)
    {
        $post = $this->postRepository->getPostId($id);
        return  view('author.post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     */
    public function edit($id)
    {
       $post=$this->postRepository->getPostId($id);
        $tags=$this->tagRepository->getTagOfIndex();
        $categories=$this->categoriesRepository->getCategoryOfIndex();
        return view('author.post.edit',compact('post','tags','categories'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @
     */
    public function update(Request $request, $id)
    {
        try {
            $this->postRepository->postUpdate($request,$id);
            $this->setSuccessMessage('Post Successfully Saved');
            return redirect()->route('author.post.index');
        }
        catch (Exception $e)
        {
            $this->setErrorMessage($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     */
    public function destroy($id)
    {
        try {
            $this->postRepository->postDelete($id);
            $this->setSuccessMessage('Post Successfully Delete');
            return redirect()->route('author.post.index');

        }
        catch (Exception $e)
        {
            $this->setErrorMessage($e->getMessage());
        }
    }
}
