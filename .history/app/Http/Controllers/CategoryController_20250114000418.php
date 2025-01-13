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
