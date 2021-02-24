<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriesRequest;
use App\Repository\CategoriesRepository;

class CategoriesController extends Controller
{
    private $categoriesRepository;
   public  function  __construct(CategoriesRepository $categoriesRepository)
   {
       $this->categoriesRepository=$categoriesRepository;
   }

    public function index()
    {
       $categories=$this->categoriesRepository->getCategoryOfIndex();
        return view('admin.category.index',compact('categories'));

    }


    public function create()
    {

        return view('admin.category.create');
    }

    /**
     * @param CategoriesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoriesRequest $request)
    {

        try {
            $this->categoriesRepository->categoryStore($request);
            $this->setSuccessMessage('Category Successfully Saved');
            return redirect()->route('admin.category.index');

        } catch (Exception $e) {
            $this->setErrorMessage($e->getMessage());
        }
        return redirect()->route('admin.category.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     */
    public function edit($id)
    {
        $category=$this->categoriesRepository->geCategoryId($id);
        return view('admin.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     */
    public function update(CategoriesRequest $request, $id)
    {
        try {
            $this->categoriesRepository->CategoryUpdate($request,$id);
            $this->setSuccessMessage('Category Successfully Update');
            return redirect()->route('admin.category.index');

        } catch (Exception $e) {
            $this->setErrorMessage($e->getMessage());
        }
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return
     */
    public function destroy($id)
    {
        try {
            $this->categoriesRepository->categoryDelete($id);
            $this->setSuccessMessage('Category Successfully Delete');
            return redirect()->route('admin.category.index');

        } catch (Exception $e) {
            $this->setErrorMessage($e->getMessage());
        }
        return redirect()->route('admin.category.index');
    }
}
