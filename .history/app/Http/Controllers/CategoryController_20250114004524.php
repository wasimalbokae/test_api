<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $Categories = Category::all();
        if ($Categories->isEmpty()) {
            return response()->json(["message" => "No Found Data"], 404);
        }
        return response()->json(["message" => "Done", "Categories" => $Categories], 200);
    }
    public function store(Request $request)
    {
        $request->validate([
            "title" => "string|required",
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
        $Category=Category::create([
            "title"=>$request->title,
            "description"=>$request->description,
            "image"=>$imgName
        ]);
        if($Category)
        return response()->json(["message" => "Done", "Category" => $Category], 200);
        return response()->json(["message" => "Error"], 405);


    }
    public function show( $id)
    {
        $category=category::where("id",$id)->first();
        if(!$category)
        return response()->json(["message" => "No Data Found"], 404);
        return response()->json(["category" => $category], 200);

    }

    public function update(Request $request, $id)
    {
        $Category=Category::find($id);
            if($Category)
            {
                if($request->title!=$Category->title)
                    $request->validate(["title"=>"min:3|max:50"]);
                if($request->description!=$Category->description)
                        $request->validate(["description"=>"min:3|max:100"]);
                if($request->hasFile("image"))
                {
                    $request->validate(["image"=>"image|mimes:jpeg,jpg,png,gif|max:10000"]);
                    $img=json_decode($Category->image);
                    $image_path = public_path("\images\categories").'\\'.$img;
                    if(file_exists($image_path) && !empty($img))
                    {
                        unlink($image_path);
                    }
                    $image=$request->file("image");
                    $imgName=$image->getClientOriginalName() . '-'. uniqid() . '.'.$image->getClientOriginalExtension();
                    $image->move(public_path("/images/categories"),$imgName);
                    $Category->image=json_encode( $imgName);
                }
                    if(!empty($request->title))
                        $Category->title=$request->title;
                    if(!empty($request->description))
                        $Category->description=$request->description;
                    $Category->save();
                    return redirect()->route('Category.index');
            }
            return redirect()->route('Category.index')->with('error', 'Not Found ID='.$id);
    }

    public function destroy(category $category)
    {
        //
    }
}
