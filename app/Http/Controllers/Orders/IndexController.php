<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;
use App\Helpers\PaginationHelper;
use App\Http\Resources\OrderResource;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    { 
         $query = Orders::with(['items', 'user', 'location']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        if ($request->filled('date_of_delivery')) {
            $query->whereDate('date_of_delivery', $request->date_of_delivery);
        }

        if ($request->filled('min_price')) {
            $query->where('total_price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('total_price', '<=', $request->max_price);
        }

        $orders = $query->paginate(10);

        return $this->successResponse(
            PaginationHelper::format($orders, OrderResource::class)
        );
       
    }
  
}
