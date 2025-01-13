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
        dd("asd");
        $request->validate([
            "title"=>"string|required",
            "description"=>"string|required",
            "image"=>"mimes:jpeg,jpg,png,gif|max:10000"
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
    public function show(category $category)
    {
        //
    }

    public function update(Request $request, category $category)
    {
        //
    }

    public function destroy(category $category)
    {
        //
    }
}
