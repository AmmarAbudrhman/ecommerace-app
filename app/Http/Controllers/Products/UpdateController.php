<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $product = Products::find($id);

        if (!$product) {
            return $this->errorResponse('Product not found', 404);
        }

        $validatedData = $request->validate([
            'category_id' => 'sometimes|required|exists:catgories,id',
            'brand_id' => 'sometimes|required|exists:brands,id',
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'is_trending' => 'boolean',
            'is_available' => 'boolean',
            'amount' => 'sometimes|required|integer|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'image' => ImageHelper::getValidationRules(false),
        ]);

        return DB::transaction(function () use ($product, $request) {
            if ($request->has('category_id')) $product->category_id = $request->category_id;
            if ($request->has('brand_id')) $product->brand_id = $request->brand_id;
            if ($request->has('name')) $product->name = $request->name;
            if ($request->has('description')) $product->description = $request->description;
            if ($request->has('price')) $product->price = $request->price;
            if ($request->has('is_trending')) $product->is_trending = $request->boolean('is_trending');
            if ($request->has('is_available')) $product->is_available = $request->boolean('is_available');
            if ($request->has('amount')) $product->amount = $request->amount;
            if ($request->has('discount')) $product->discount = $request->discount;

            if ($request->hasFile('image')) {
                if ($product->image) {
                    ImageHelper::delete($product->image);
                }
                $product->image = ImageHelper::upload($request->file('image'), 'products');
            }

            $product->save();

            return $this->successResponse($product, 'Product updated successfully');
        });
    }
}
