<?php

namespace App\Http\Controllers\Brands;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __invoke(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
        ]);

        $brand = new Brands();
        $brand->name = $request->name;
        $brand->save();

        return $this->successResponse($brand, 'Brand created successfully', 201);
    }
}
