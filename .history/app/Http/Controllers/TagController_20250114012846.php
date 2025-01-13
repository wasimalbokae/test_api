<?php

namespace App\Http\Controllers;

use App\Models\tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = tag::all();
        if ($tags->isEmpty()) {
            return response()->json(["message" => "No Found Data"], 404);
        }
        return response()->json(["message" => "Done", "Categories" => $tags], 200);
    }
    public function store(Request $request)
    {
        $request->validate([
            "title" => "string|required|unique:categories",
            "description" => "string|required",
            "image" => "mimes:jpeg,jpg,png,gif|max:10000"
        ]);
        $imgName="";
        if($request->hasFile("image"))
        {
            $image=$request->image;
            $imgName=$image->getClientOriginalName() . '-'. uniqid() . '.'.$image->getClientOriginalExtension();
            $image->move(public_path("/images/categories"),$imgName);
        }
        $tag=tag::create([
            "title"=>$request->title,
            "description"=>$request->description,
            "image"=>$imgName
        ]);
        if($tag)
        return response()->json(["message" => "Done", "tag" => $tag], 200);
        return response()->json(["message" => "Error"], 405);


    }
    public function show( $id)
    {
        $tag=tag::where("id",$id)->first();
        if(!$tag)
        return response()->json(["message" => "No Data Found"], 404);
        return response()->json(["tag" => $tag], 200);

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "title" => "string|nullable",
            "description" => "string|nullable",
            "image" => "mimes:jpeg,jpg,png,gif|max:10000|nullable"
        ]);
        $tag=tag::find($id);
            if($tag)
            {
                if($request->hasFile("image"))
                {
                    $img=json_decode($tag->image);
                    $image_path = public_path("\images\categories").'\\'.$img;
                    if(file_exists($image_path) && !empty($img))
                    {
                        unlink($image_path);
                    }
                    $image=$request->file("image");
                    $imgName=$image->getClientOriginalName() . '-'. uniqid() . '.'.$image->getClientOriginalExtension();
                    $image->move(public_path("/images/categories"),$imgName);
                    $tag->image=json_encode( $imgName);
                }
                    if(!empty($request->title))
                        $tag->title=$request->title;
                    if(!empty($request->description))
                        $tag->description=$request->description;
                    $tag->save();
                    return response()->json(["message" => "Updated"], 200);
            }
            return response()->json(["message" => "Error"], 404);
    }

    public function destroy($id)
    {
        $tag = tag::find($id);
        if($tag)
        {
            $tag->delete();
            return response()->json(["message" => "Deleted"], 200);
        }
        return response()->json(["message" => "Error"], 404);
    }
}
