<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Orders/Index', [
            'orders' => auth()->user()->orders()
                ->with([
                    'restaurant:id,name',
                    'items:id,order_id,menu_name,unit_price,quantity,subtotal',
                ])
                ->latest()
                ->get(),
            'hideCartBar' => true,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'recipient_name' => ['required', 'string', 'max:255'],
            'recipient_phone' => ['required', 'string', 'max:20'],
            'delivery_address' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        $order = DB::transaction(function () use ($validated) {
            $cart = auth()->user()->cart()
                ->with(['restaurant', 'items.menu'])
                ->lockForUpdate()
                ->firstOrFail();

            abort_if($cart->items->isEmpty(), 422, 'Your cart is empty.');

            $deliveryFee = 10000;
            $subtotal = $cart->items->sum(
                fn ($item) => (float) $item->menu->price * $item->quantity
            );
            $tax = $subtotal * 0.11;

            $subtotal = $subtotal + $tax;

            $order = Order::create([
                'order_number' => 'ORD-'.now()->format('YmdHis').'-'.Str::upper(Str::random(5)),
                'user_id' => auth()->id(),
                'restaurant_id' => $cart->restaurant_id,
                'recipient_name' => $validated['recipient_name'],
                'recipient_phone' => $validated['recipient_phone'],
                'delivery_address' => $validated['delivery_address'],
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total' => $subtotal + $deliveryFee,
                'status' => 'completed',
                'payment_method' => 'cod',
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($cart->items as $cartItem) {
                $unitPrice = (float) $cartItem->menu->price;

                $order->items()->create([
                    'menu_id' => $cartItem->menu_id,
                    'menu_name' => $cartItem->menu->name,
                    'unit_price' => $unitPrice,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $unitPrice * $cartItem->quantity,
                ]);
            }

            $cart->items()->delete();
            $cart->update(['restaurant_id' => null]);

            return $order;
        });

        return redirect()->route('orders.show', $order);
    }

    public function show(Order $order): Response
    {
        abort_unless($order->user_id === auth()->id(), 404);

        return Inertia::render('Orders/Show', [
            'order' => $order->load([
                'restaurant:id,name,address',
                'items:id,order_id,menu_name,unit_price,quantity,subtotal',
            ]),
            'hideCartBar' => true,
        ]);
    }
}
