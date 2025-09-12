<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Technician;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use App\Jobs\NotifyOrderClosed; // We'll create this later
use Illuminate\Support\Facades\Cache;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * With filters and pagination.
     */
    public function index(Request $request)
    {
        $orders = Order::query()
            ->when($request->has('status'), function ($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->when($request->has('from_date'), function ($query) use ($request) {
                return $query->whereDate('created_at', '>=', $request->from_date);
            })
            ->when($request->has('to_date'), function ($query) use ($request) {
                return $query->whereDate('created_at', '<=', $request->to_date);
            })
            ->when($request->has('customer_id'), function ($query) use ($request) {
                return $query->where('customer_id', $request->customer_id);
            })
            ->with(['customer', 'technician'])
            ->latest()
            ->paginate(10); // Paginación

        return Cache::remember('orders_list', 60, function () use ($orders) {
            return response()->json($orders);
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $order = Order::create($request->validated());

        // Invalidate cache
        Cache::forget('orders_list');

        return response()->json($order, 201);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['customer', 'technician']);
        return response()->json($order);
    }

    /**
     * Assign a technician to the order.
     */
    public function assignTechnician(Order $order, Request $request)
    {
        $request->validate(['technician_id' => 'required|exists:technicians,id']);

        if ($order->status === 'cancelled') {
            return response()->json(['message' => 'Cannot assign a technician to a cancelled order.'], 400);
        }

        $order->technician_id = $request->technician_id;
        $order->save();

        // Invalidate cache
        Cache::forget('orders_list');

        return response()->json($order);
    }

    /**
     * Mark the order as done and set the estimated cost.
     */
    public function markAsDone(Order $order, Request $request)
    {
        $request->validate(['estimated_cost' => 'required|numeric|min:0']);

        $order->status = 'done';
        $order->estimated_cost = $request->estimated_cost;
        $order->save();

        // Dispatch the job
        NotifyOrderClosed::dispatch($order);

        // Invalidate cache
        Cache::forget('orders_list');

        return response()->json($order);
    }
}