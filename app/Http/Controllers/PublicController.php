<?php

namespace App\Http\Controllers;

use App\Http\Resources\PublicMenuResource;
use App\Models\Menu;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicController extends Controller
{
    /**
     * Display the welcome page with menus and their products.
     */
    public function show()
    {
        // Load the menus, ordered by position
        $menus = Menu::orderBy('position', 'asc')->get();

        // Return the data using Inertia
        return Inertia::render('Welcome', [
            'menus' => PublicMenuResource::collection($menus)
        ]);
    }

    /**
     * Display the about page.
     */
    public function about()
    {
        return Inertia::render('About'); // Assuming the Vue component is named About.vue
    }
}
