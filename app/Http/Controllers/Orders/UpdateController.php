<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\OrderResource;

class UpdateController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $order = Orders::find($id);

        if (!$order) {
            return $this->errorResponse('Order not found', 404);
        }

        $validatedData = $request->validate([
            'status' => 'sometimes|required|in:pending,processing,completed,cancelled',
            'location_id' => 'sometimes|required|exists:_locations,id',
            'total_price' => 'sometimes|required|numeric|min:0',
            'date_of_delivery' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($order, $request) {
            if ($request->has('status')) {
                // Logic for status flow could go here (e.g., can't go from cancelled to pending)
                $order->status = $request->status;
            }
            if ($request->has('location_id')) {
                $order->location_id = $request->location_id;
            }
            if ($request->has('total_price')) {
                $order->total_price = $request->total_price;
            }
            if ($request->has('date_of_delivery')) {
                $order->date_of_delivery = $request->date_of_delivery;
            }

            $order->save();

            $order->load(['items', 'user', 'location']);

            return $this->successResponse(new OrderResource($order), 'Order updated successfully');
        });
    }
}
