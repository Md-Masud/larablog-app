<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTagRequest;
use App\Repository\TagRepository;
class TagController extends Controller
{
    private $tagRepository;
    public  function  __construct(TagRepository $tagRepository)
    {
        $this->tagRepository=$tagRepository;
    }

    public function index()
    {
      $tags=$this->tagRepository->getTagOfIndex();
       return view('admin.tag.index',compact('tags'));
    }

    public function create()
    {

        return  view('admin.tag.create');
    }

    /**
     * @param CreateTagRequest $request
     * @return mixed
     */
    public function store(CreateTagRequest $request)
    {

        try {
            $this->tagRepository->tagStore($request);
            $this->setSuccessMessage('Tag Successfully Saved');
            return redirect()->route('admin.tag.index');

        } catch (Exception $e) {
            $this->setErrorMessage($e->getMessage());
        }

    }


    /**
     * @param $id
     */
    public function edit($id)
    {
        $tag=$this->tagRepository->getagId($id);
        return  view('admin.tag.edit',compact('tag'));
    }

    /**
     * @param CreateTagRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CreateTagRequest $request, $id)
    {
        try {
            $this->tagRepository->tagUpdate($request,$id);
            $this->setSuccessMessage('Tag Successfully Update');
            return redirect()->route('admin.tag.index');
        } catch (Exception $e) {
            $this->setErrorMessage($e->getMessage());
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $this->tagRepository->tagDelete($id);
            $this->setSuccessMessage('Tag Successfully Delete');
            return redirect()->route('admin.tag.index');
        } catch (Exception $e) {
            $this->setErrorMessage($e->getMessage());
        }
    }
}
