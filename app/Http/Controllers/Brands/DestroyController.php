<?php

namespace App\Http\Controllers\Brands;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DestroyController extends Controller
{
    public function __invoke($id)
    {
        $brand = Brands::find($id);

        if (!$brand) {
            return $this->errorResponse('Brand not found', 404);
        }

        return DB::transaction(function () use ($brand) {
            $brand->delete();
            return $this->successResponse(null, 'Brand deleted successfully');
        });
    }
}
