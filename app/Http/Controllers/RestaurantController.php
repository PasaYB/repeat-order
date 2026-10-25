<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RestaurantController extends Controller
{
    public function show(Restaurant $restaurant): Response
    {
        $menus = Menu::query()
            ->with('restaurant')
            ->when($restaurant, fn ($query) => $query->whereBelongsTo($restaurant))
            ->where('is_available', true)
            ->orderBy('name')
            ->get();

        return Inertia::render('Restaurants', [
            'menus' => $menus,
            'restaurants' => Restaurant::query()
                ->orderBy('name')
                ->get(['id', 'name']),
            'restaurant' => $restaurant,
        ]);
    }
}
