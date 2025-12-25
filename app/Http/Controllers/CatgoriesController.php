<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catgories;
use App\Helpers\ImageHelper;

class CatgoriesController extends Controller
{
      public function index()
    {
        $catgories = Catgories::paginate(10);

        return response()->json($catgories, 200);
    }

    public function show($id)
    {
        $catgory = Catgories::find($id);

        if (!$catgory) {
            return response()->json(['message' => 'catgory not found'], 404);
        }

        return response()->json($catgory, 200);
    }
    public function store(Request $request)
    {
        try
        {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:catgories,name',
                'image' => ImageHelper::getValidationRules(),
            ]);
            $catgory=new Catgories();
            $catgory->name=$request->name;
            
            if ($request->hasFile('image')) {
                $catgory->image = ImageHelper::upload($request->file('image'), 'categories');
            }


            $catgory->save();
            return response()->json($catgory, 201);
        }
        catch (\Exception $e)
        {
            return response()->json(['message' => 'Failed to create catgory', 'error' => $e->getMessage()], 500);
        }
    }

    public function update_catgory(Request $request, $id)
    {
        try
        {
            $catgory = Catgories::find($id);
            if (!$catgory) {
                return response()->json(['message' => 'catgory not found'], 404);
            }

            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:catgories,name,' . $id,
                'image' => ImageHelper::getValidationRules(),
            ]);

            $catgory->name = $request->name;

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($catgory->image) {
                    ImageHelper::delete($catgory->image);
                }
                $catgory->image = ImageHelper::upload($request->file('image'), 'categories');
            }

            $catgory->save();
            return response()->json($catgory, 200);
           


         }
        catch (\Exception $e)
        {
            return response()->json(['message' => 'Failed to update catgory', 'error' => $e->getMessage()], 500);
        }
    }
    public function destroy($id)
    {
        $catgory=catgories::find($id);
        if (!$catgory) {
            return response()->json(['message' => 'catgory not found'], 404);
        }
        
        if ($catgory->image) {
            ImageHelper::delete($catgory->image);
        }
        
        $catgory->delete();
        return response()->json(['message' => 'catgory deleted successfully'], 200);
    }
}
