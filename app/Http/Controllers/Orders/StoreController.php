<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\OrderResource;

class StoreController extends Controller
{
    public function __invoke(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'location_id' => 'required|exists:_locations,id',
            'total_price' => 'required|numeric|min:0',
            'date_of_delivery' => 'nullable|string',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        return DB::transaction(function () use ($request) {
            $order = new Orders();
            $order->user_id = $request->user_id;
            $order->location_id = $request->location_id;
            $order->total_price = $request->total_price;
            $order->status = 'pending'; 
            $order->date_of_delivery = $request->date_of_delivery;
            
            $order->save();

            foreach ($request->items as $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            $order->load(['items', 'user', 'location']);

            return $this->successResponse(new OrderResource($order), 'Order created successfully', 201);
        });
    }
}
