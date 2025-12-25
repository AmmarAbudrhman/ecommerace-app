<?php

namespace App\Http\Controllers\Locations;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DestroyController extends Controller
{
    public function __invoke($id)
    {
        $location = Location::find($id);

        if (!$location) {
            return $this->errorResponse('Location not found', 404);
        }

        return DB::transaction(function () use ($location) {
            $location->delete();
            return $this->successResponse(null, 'Location deleted successfully');
        });
    }
}
