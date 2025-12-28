<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DestroyController extends Controller
{
    public function __invoke($id)
    {
        $order = Orders::find($id);

        if (!$order) {
            return $this->errorResponse('Order not found', 404);
        }

        return DB::transaction(function () use ($order) {
            $order->delete();
            return $this->successResponse(null, 'Order deleted successfully');
        });
    }
}
