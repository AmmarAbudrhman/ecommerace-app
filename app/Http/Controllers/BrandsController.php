<?php

namespace App\Http\Controllers;
use App\Models\Brands;

use Illuminate\Http\Request;

class BrandsController extends Controller
{
    public function index()
    {
        $brands = Brands::paginate(10);

        return response()->json($brands, 200);
    }

    public function show($id)
    {
        $brand = Brands::find($id);

        if (!$brand) {
            return response()->json(['message' => 'Brand not found'], 404);
        }

        return response()->json($brand, 200);
    }
    public function store(Request $request)
    {
        try
        {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:brands,name',
            ]);
            $brand=new Brands();
            $brand->name=$request->name;
            $brand->save();
            return response()->json($brand, 201);
        }
        catch (\Exception $e)
        {
            return response()->json(['message' => 'Failed to create brand', 'error' => $e->getMessage()], 500);
        }
    }

    public function update_brand(Request $request, $id)
    {
        try
        {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:brands,name',
            ]);
            $brand= Brands::where(column: 'id',operator: $id)->update('name',$request->name);
            return response()->json($brand, 200);
           


         }
        catch (\Exception $e)
        {
            return response()->json(['message' => 'Failed to update brand', 'error' => $e->getMessage()], 500);
        }
    }
    public function destroy($id)
    {
        $brand=Brands::find($id);
        if (!$brand) {
            return response()->json(['message' => 'Brand not found'], 404);
        }
        $brand->delete();
        return response()->json(['message' => 'Brand deleted successfully'], 200);
    }
}
