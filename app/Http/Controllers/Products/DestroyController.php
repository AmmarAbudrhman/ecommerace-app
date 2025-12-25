<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DestroyController extends Controller
{
    public function __invoke($id)
    {
        $product = Products::find($id);

        if (!$product) {
            return $this->errorResponse('Product not found', 404);
        }

        return DB::transaction(function () use ($product) {
            if ($product->image) {
                ImageHelper::delete($product->image);
            }

            $product->delete();

            return $this->successResponse(null, 'Product deleted successfully');
        });
    }
}
