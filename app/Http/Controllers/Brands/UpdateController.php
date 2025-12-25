<?php

namespace App\Http\Controllers\Brands;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $id,
        ]);

        $brand = Brands::find($id);

        if (!$brand) {
            return $this->errorResponse('Brand not found', 404);
        }

        $brand->name = $request->name;
        $brand->save();

        return $this->successResponse($brand, 'Brand updated successfully');
    }
}
