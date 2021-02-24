<?php
namespace App\Repository;
use App\Models\Category;
use App\Repository\Image\CategoryImage;


class CategoriesRepository extends CategoryImage
{

    public function getCategoryOfIndex()
    {
        $category=Category::latest()->get();
        return $category;
    }
    public function categoryStore($request)
    {
        //image create logic
        $this->imageStore($request);
        $category=Category::create([
            "name"=>$request->name,
            "slug"=>$this->slug,
            "image"=>$this->imagename,
        ]);
      return $category;
    }
    public  function  geCategoryId($id)
    {
     $id=Category::find($id);
     return $id;
    }

    public  function  CategoryUpdate($request ,$id)
    {
        $this->imageStore($request);
         return  Category::where('id',$id)->update([
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
