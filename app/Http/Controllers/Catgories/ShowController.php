<?php

namespace App\Http\Controllers\Catgories;

use App\Http\Controllers\Controller;
use App\Models\Catgories;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function __invoke($id)
    {
        $catgory = Catgories::find($id);

        if (!$catgory) {
            return $this->errorResponse('Category not found', 404);
        }

        return $this->successResponse($catgory);
    }
}
