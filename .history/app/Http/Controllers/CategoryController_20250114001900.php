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
        $vali=$request->validate([
            "title"=>"string|required",
            "description"=>"string:200",
            "image"=>"mimes:jpeg,jpg,png,gif|max:10000",
        ]);
        $image=$request->image;
        $imgName=$image->getClientOriginalName() . '-'. uniqid() . '.'.$image->getClientOriginalExtension();
        $image->move(public_path("/images/categories"),$imgName);
        $Category=Category::create($vali);
        return response()->json(["message" => "Done", "Category" => $Category], 200);

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
