<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Helpers\PaginationHelper;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = Products::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->has('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }
        if ($request->has('is_trending')) {
            $query->where('is_trending', filter_var($request->is_trending, FILTER_VALIDATE_BOOLEAN));
        }
        if ($request->has('is_available')) {
            $query->where('is_available', filter_var($request->is_available, FILTER_VALIDATE_BOOLEAN));
        }
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->paginate(10);
        return $this->successResponse(PaginationHelper::format($products));
    }
}
