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
        return response()->json(["message" => "Done", "tags" => $tags], 200);
    }
    public function store(Request $request)
    {
        dd($request->word);
        $request->validate([
            "word" => "string|required|unique:tags"
        ]);
        $tag=tag::create([
            "word"=>$request->word,
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
            "word" => "string|nullable"
        ]);
        $tag=tag::find($id);
            if($tag)
            {
                    $tag->word=$request->word;
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
