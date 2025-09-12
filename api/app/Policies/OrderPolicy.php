<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    /**
     * Determine whether the user can view the estimated cost of the order.
     */
    public function viewCost(User $user, Order $order): bool
    {
        // Admin can view any cost
        if ($user->role === 'admin') {
            return true;
        }

        // Agent can only view the cost if it's their own customer's order
        return $order->customer_id === $user->id;
    }

    /**
     * Determine whether the user can cancel the order.
     */
    public function cancel(User $user, Order $order): bool
    {
        // Only admin can cancel an order
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can assign a technician.
     */
    public function assignTechnician(User $user, Order $order): bool
    {
        return $user->role === 'admin' || $user->role === 'agent';
    }

    /**
     * Determine whether the user can mark an order as done.
     */
    public function markAsDone(User $user, Order $order): bool
    {
        return $user->role === 'admin' || $user->role === 'agent';
    }
}