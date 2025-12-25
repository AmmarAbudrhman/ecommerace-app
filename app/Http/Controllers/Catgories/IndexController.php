<?php

namespace App\Http\Controllers\Catgories;

use App\Http\Controllers\Controller;
use App\Models\Catgories;
use Illuminate\Http\Request;
use App\Helpers\PaginationHelper;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = Catgories::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $catgories = $query->paginate(10);

        return $this->successResponse(PaginationHelper::format($catgories));
    }
}
