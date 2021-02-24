<?php


namespace App\Repository\Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostImage
{
   protected  $disk='post/';
    protected  $imagename;
    protected $slug;
    public  function  imageStore($request)
    {

        $image = $request->file('image');
        $this->slug = Str::slug($request->title);

        if (isset($image)) {
//            make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $this->imagename = $this->slug . '-' . $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
//            check category dir is exists
            if (!Storage::disk('public')->exists($this->disk)) {

                Storage::disk('public')->makeDirectory($this->disk);
            }
//            resize image for category and upload
            $postImage = Image::make($image)->resize(1600,1066)->save();
            Storage::disk('public')->put($this->disk.'/'.$this->imagename,$postImage);

        } else {
            $imagename = "default.png";
        }
        return $this;
    }
    public function imageDelete($post)
    {

        if (Storage::disk('public')->exists('post/' . $post->image)) {
            Storage::disk('public')->delete('post/' . $post->image);
        }

    }

    }

