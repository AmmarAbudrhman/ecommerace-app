<?php

namespace App\Http\Controllers\Brands;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use Illuminate\Http\Request;
use App\Helpers\PaginationHelper;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = Brands::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $brands = $query->paginate(10);
        return $this->successResponse(PaginationHelper::format($brands));
    }
}
