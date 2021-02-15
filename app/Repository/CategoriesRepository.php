<?php
namespace App\Repository;
use App\Models\Categories;
use App\Repository\Image\CategoryImage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;

class CategoriesRepository extends CategoryImage
{

    public function getCategoryOfIndex()
    {
        $categories=Categories::latest()->get();
        return $categories;
    }
    public function categoryStore($request)
    {
        //image create logic
        $this->imageStore($request);
        $category=Categories::create([
            "name"=>$request->name,
            "slug"=>$this->slug,
            "image"=>$this->imagename,
        ]);
      return $category;
    }
    public  function  geCategoryId($id)
    {
     $id=Categories::find($id);
     return $id;
    }

    public  function  CategoryUpdate($request ,$id)
    {
        $this->imageStore($request);
         return  Categories::where('id',$id)->update([
                  "name"=>$request->name,
                  "slug"=>$this->slug,
                  "image"=>$this->imagename,
                ]);


    }
    public function  categoryDelete($id)
    {

        $category=$this->geCategoryId($id) ;
        $this->imageDelete($category);
        return $category->delete();
    }


}
