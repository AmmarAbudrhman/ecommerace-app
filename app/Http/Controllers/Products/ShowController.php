<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;

class ShowController extends Controller
{
    public function __invoke($id)
    {
        $product = Products::find($id);

        if (!$product) {
            return $this->errorResponse('Product not found', 404);
        }

        return $this->successResponse(new ProductResource($product));
    }
}
