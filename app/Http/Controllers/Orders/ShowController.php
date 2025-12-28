<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;

class ShowController extends Controller
{
    public function __invoke($id)
    {
        $order = Orders::with(['items', 'user', 'location'])->find($id);

        if (!$order) {
            return $this->errorResponse('Order not found', 404);
        }

        return $this->successResponse(new OrderResource($order));
    }
}
