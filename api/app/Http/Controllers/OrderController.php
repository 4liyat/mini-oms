<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Jobs\NotifyOrderClosed;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Order::class);
        $query = Order::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        return response()->json($query->paginate(10));
    }

    public function cancel(Order $order)
    {
        $this->authorize('cancel', $order);
        $order->status = 'cancelled';
        $order->save();
        return response()->json(['message' => 'Order cancelled successfully.']);
    }

    public function markAsDone(Request $request, Order $order)
    {
        $this->authorize('markAsDone', $order);
        
        $request->validate([
            'estimated_cost' => 'required|numeric|min:0',
        ]);

        $order->update([
            'status' => 'done',
            'estimated_cost' => $request->estimated_cost
        ]);

        NotifyOrderClosed::dispatch($order);

        return response()->json(['message' => 'Order marked as done successfully.', 'order' => $order]);
    }
}