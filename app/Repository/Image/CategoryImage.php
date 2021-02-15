<?php


namespace App\Repository\Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CategoryImage
{
    protected  $imagename;
    protected $slug;
   public  function  imageStore($request)
   {
       $image = $request->file('image');
       $this->slug = Str::slug($request->name);

       if (isset($image)) {
//            make unique name for image
           $currentDate = Carbon::now()->toDateString();
           $this->imagename = $this->slug . '-' . $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
//            check category dir is exists
           if (!Storage::disk('public')->exists('category')) {

               Storage::disk('public')->makeDirectory('category');
           }
//            resize image for category and upload
           $category = Image::make($image)->resize(1600, 479)->save();
           Storage::disk('public')->put('category/' . $this->imagename, $category);

           //            check category slider dir is exists
           if (!Storage::disk('public')->exists('category/slider')) {
               Storage::disk('public')->makeDirectory('category/slider');
           }
           //            resize image for category slider and upload
           $slider = Image::make($image)->resize(500, 333)->save();
           Storage::disk('public')->put('category/slider/' . $this->imagename, $slider);

       } else {
           $imagename = "default.png";
       }
       return $this;
   }
   public function imageDelete($category)
   {

       if (Storage::disk('public')->exists('category/'.$category->image))
       {
           Storage::disk('public')->delete('category/'.$category->image);
       }

       if (Storage::disk('public')->exists('category/slider/'.$category->image))
       {
           Storage::disk('public')->delete('category/slider/'.$category->image);
       }


   }
}
