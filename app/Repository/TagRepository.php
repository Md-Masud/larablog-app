<?php
namespace App\Repository;
use App\Models\Tag;
use Illuminate\Support\Str;

class TagRepository
{
    public function getTagOfIndex()
    {
        $tags = Tag::select('id', 'name', 'slug', 'created_at', 'updated_at')->get();
        return $tags;
    }

    public function tagStore($request)
    {
        $tags = Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        return $tags;
    }

    public function getagId($id)
    {
        $tag = Tag::find($id);
        return $tag;
    }

    public function tagUpdate($request, $id)
    {
        return Tag::where('id', $id)->update([
            "name" => $request->name,
            "slug" => Str::slug($request->name),

        ]);

    }

    public function tagDelete($id)
    {
        return $this->getagId($id)->delete();
    }

}
