<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class CartController extends Controller
{
    public function index(): Response
    {
        $cart = auth()->user()->cart()
            ->with([
                'restaurant:id,name,slug',
                'items.menu:id,name,price,image,is_available',
            ])
            ->first();

        return Inertia::render('Cart', [
            'cart' => $cart,
            'hideCartBar' => true
        ]);
    }

    public function checkout(): Response
    {
        $cart = auth()->user()->cart()
            ->with([
                'restaurant:id,name,address',
                'items.menu:id,name,price,image',
            ])
            ->first();

        abort_if(! $cart || ! $cart->items->isNotEmpty(), 404, 'Your cart is empty.');

        return Inertia::render('Checkout', [
            'cart' => $cart,
            'hideCartBar' => true,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'replace_existing' => ['sometimes', 'boolean'],
            'items.*.menu_id' => [
                'required',
                'integer',
                'exists:menus,id',
            ],
            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
                'max:99',
            ],
        ]);

        $menus = Menu::with('restaurant')
            ->whereIn('id', collect($validated['items'])->pluck('menu_id'))
            ->get()
            ->keyBy('id');

        $menu = $menus->first();

        // dd($menu->toArray());

        if (! $menu->is_available || ! $menu->restaurant->is_open) {
            throw ValidationException::withMessages([
                'menu_id' => 'Menu atau restoran sedang tidak tersedia.',
            ]);
        }

        $cart = DB::transaction(function () use ($validated, $menus, $menu) {
            $cart = Cart::firstOrCreate(
                ['user_id' => auth()->id()],
                ['restaurant_id' => $menu->restaurant_id]
            );

            // if cart null user can start adding new cart
            if ($cart->restaurant_id === null) {
                $cart->update([
                    'restaurant_id' => $menu->restaurant_id,
                ]);
            }

            if ((int) $cart->restaurant_id !== (int) $menu->restaurant_id) {
                if (! ($validated['replace_existing'] ?? false)) {
                    throw ValidationException::withMessages([
                        'cart' => 'Keranjang berisi menu dari restoran lain. Lanjutkan untuk mengganti keranjang dengan menu baru?',
                    ]);
                }

                $cart->items()->delete();
                $cart->update([
                    'restaurant_id' => $menu->restaurant_id,
                ]);
            }

            // one cart for one restaurant
            if ((int) $cart->restaurant_id !== (int) $menu->restaurant_id) {
                throw ValidationException::withMessages([
                    'items' => 'Keranjang hanya dapat berisi menu dari satu restoran. Kosongkan keranjang terlebih dahulu.',
                ]);
            }

            foreach ($validated['items'] as $itemData) {
                $item = $cart->items()
                    ->where('menu_id', $itemData['menu_id'])
                    ->first();

                if ($item) {
                    $item->increment('quantity', $itemData['quantity']);
                } else {
                    $cart->items()->create([
                        'menu_id' => $itemData['menu_id'],
                        'quantity' => $itemData['quantity'],
                    ]);
                }
            }

            return $cart;
        });

        return back();
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $cart = auth()->user()->cart()->firstOrFail();
        abort_unless($cartItem->cart_id === $cart->id, 404);

        $cartItem->update([
            'quantity' => $validated['quantity'],
        ]);

        return back();
    }

    public function destroy(CartItem $cartItem)
    {
        $cart = auth()->user()->cart()->firstOrFail();
        abort_unless($cartItem->cart_id === $cart->id, 404);

        $cartItem->delete();

        if (! $cart->items()->exists()) {
            $cart->update([
                'restaurant_id' => null,
            ]);
        }

        return back();
    }
}
