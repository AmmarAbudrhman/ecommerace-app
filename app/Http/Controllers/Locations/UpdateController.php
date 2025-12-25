<?php

namespace App\Http\Controllers\Locations;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $location = Location::find($id);

        if (!$location) {
            return $this->errorResponse('Location not found', 404);
        }

        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'street' => 'required|string|max:255',
            'building_number' => 'required|string|max:50',
            'area' => 'required|string|max:255',
        ]);

        $location->user_id = $request->user_id;
        $location->street = $request->street;
        $location->building_number = $request->building_number;
        $location->area = $request->area;
        $location->save();

        return $this->successResponse($location, 'Location updated successfully');
    }
}
