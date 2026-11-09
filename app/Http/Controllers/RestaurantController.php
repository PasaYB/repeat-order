<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class RestaurantController extends Controller
{
    public function index(Request $request): Response
    {
        $search = trim((string) $request->query('search'));

        return Inertia::render('Restaurants/Index', [
            'restaurants' => Restaurant::query()
                ->with('category')
                ->when($search, fn ($query) => $query->where('name', 'like', "%{$search}%"))
                ->orderBy('name')
                ->get()
                ->map(fn (Restaurant $restaurant) => [
                    ...$restaurant->toArray(),
                    'image_url' => $restaurant->image
                        ? Storage::url($restaurant->image)
                        : null,
                ]),
            'search' => $search,
        ]);
    }

    public function show(Restaurant $restaurant): Response
    {
        $menus = Menu::query()
            ->with('restaurant')
            ->when($restaurant, fn ($query) => $query->whereBelongsTo($restaurant))
            ->where('is_available', true)
            ->orderBy('name')
            ->get();

        return Inertia::render('Restaurants/Show', [
            'menus' => $menus,
            'restaurants' => Restaurant::query()
                ->orderBy('name')
                ->get(['id', 'name']),
            'restaurant' => $restaurant,
        ]);
    }
}
