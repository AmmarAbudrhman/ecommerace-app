<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    public function __invoke(Request $request)
    {
        $validatedData = $request->validate([
            'category_id' => 'required|exists:catgories,id',
            'brand_id' => 'required|exists:brands,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'is_trending' => 'boolean',
            'is_available' => 'boolean',
            'amount' => 'required|integer|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'image' => ImageHelper::getValidationRules(true),
        ]);

        return DB::transaction(function () use ($request) {
            $product = new Products();
            $product->category_id = $request->category_id;
            $product->brand_id = $request->brand_id;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->is_trending = $request->boolean('is_trending', false);
            $product->is_available = $request->boolean('is_available', false);
            $product->amount = $request->amount;
            $product->discount = $request->discount ?? 0;

            if ($request->hasFile('image')) {
                $product->image = ImageHelper::upload($request->file('image'), 'products');
            }

            $product->save();

            return $this->successResponse($product, 'Product created successfully', 201);
        });
    }
}
