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
        $request->validate([
            "title" => "string|unique:categories|nullable",
            "description" => "string|nullable",
            "image" => "mimes:jpeg,jpg,png,gif|max:10000|nullable"
        ]);
        $Category=Category::find($id);
            if($Category)
            {
                if($request->hasFile("image"))
                {
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
                    return response()->json(["message" => "Updated"], 200);
            }
            return response()->json(["message" => "Error"], 404);
    }

    public function destroy($id)
    {
        $Category = Category::find($id);
        if($Category)
        {
            $Category->delete();
            return response()->json(["message" => "Deleted"], 200);
        }
        return response()->json(["message" => "Error"], 404);
    }
}
