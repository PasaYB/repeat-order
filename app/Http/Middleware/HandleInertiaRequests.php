<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $cart = $request->user()?->cart()
            ->with([
                'restaurant:id,name',
                'items.menu:id,name,price',
            ])
            ->first();

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user()
                    ? [
                        ...$request->user()->toArray(),
                        'image_url' => $request->user()->image
                            ? Storage::disk('public')->url($request->user()->image)
                            : null,
                    ]
                    : null,
            ],
            'cartSummary' => $cart
                ? [
                    'restaurant' => $cart->restaurant?->only(['id', 'name']),
                    'items' => $cart->items->map(fn ($item) => [
                        'id' => $item->id,
                        'menu_id' => $item->menu_id,
                        'name' => $item->menu->name,
                        'quantity' => $item->quantity,
                        'subtotal' => (float) $item->menu->price * $item->quantity,
                    ])->values(),
                    'item_count' => $cart->items->sum('quantity'),
                    'total' => $cart->items->sum(
                        fn ($item) => (float) $item->menu->price * $item->quantity
                    ),
                ]
                : null,
        ];
    }
}
