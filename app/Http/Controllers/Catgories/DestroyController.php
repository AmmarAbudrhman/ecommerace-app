<?php

namespace App\Http\Controllers\Catgories;

use App\Http\Controllers\Controller;
use App\Models\Catgories;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;

class DestroyController extends Controller
{
    public function __invoke($id)
    {
        $catgory = Catgories::find($id);
        if (!$catgory) {
            return $this->errorResponse('Category not found', 404);
        }

        if ($catgory->image) {
            ImageHelper::delete($catgory->image);
        }

        $catgory->delete();
        return $this->successResponse(null, 'Category deleted successfully');
    }
}
