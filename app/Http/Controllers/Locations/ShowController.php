<?php

namespace App\Http\Controllers\Locations;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Helpers\PaginationHelper;
use App\Http\Resources\LocationResource;

class ShowController extends Controller
{
    public function __invoke($id)
    {
        $location = Location::find($id);

        if (!$location) {
            return $this->errorResponse('Location not found', 404);
        }

        return $this->successResponse(new LocationResource($location));
    }
}