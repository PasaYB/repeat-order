<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Dashboard', [
            'restaurants' => Restaurant::with('category')
                ->orderBy('name')
                ->get()
                ->map(fn (Restaurant $restaurant) => [
                    ...$restaurant->toArray(),
                    'image_url' => $restaurant->image
                        ? Storage::url($restaurant->image)
                        : null,
                ]),
        ]);
    }
}
