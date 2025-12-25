<?php

namespace App\Http\Controllers\Locations;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function __invoke(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'street' => 'required|string|max:255',
            'building_number' => 'required|string|max:50',
            'area' => 'required|string|max:255',
        ]);

        // Create a new location
        $location = new Location();
        $location->user_id = $validatedData['user_id'];
        $location->street = $validatedData['street'];
        $location->building_number = $validatedData['building_number'];
        $location->area = $validatedData['area'];
        $location->save();

        return $this->successResponse($location, 'Location created successfully', 201);
    }
}
