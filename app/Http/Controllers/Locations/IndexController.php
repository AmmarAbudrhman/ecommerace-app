<?php

namespace App\Http\Controllers\Locations;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Helpers\PaginationHelper;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = Location::query();

        if ($request->has('street')) {
            $query->where('street', 'like', '%' . $request->street . '%');
        }
        if ($request->has('building_number')) {
            $query->where('building_number', 'like', '%' . $request->building_number . '%');
        }
        if ($request->has('area')) {
            $query->where('area', 'like', '%' . $request->area . '%');
        }
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $locations = $query->paginate(10);
        return $this->successResponse(PaginationHelper::format($locations));
    }
}
