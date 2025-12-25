<?php

namespace App\Http\Controllers\Brands;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function __invoke($id)
    {
        $brand = Brands::find($id);

        if (!$brand) {
            return $this->errorResponse('Brand not found', 404);
        }

        return $this->successResponse($brand);
    }
}
