<?php

namespace App\Http\Controllers;

use App\Http\Resources\PublicMenuResource;
use App\Models\Branch;
use App\Models\Menu;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicMenuController extends Controller
{
    public function show($branch, $menu)
    {
        // Load the branch, with menus and their meals
        $menu = Menu::with('meals')->findOrFail($menu);

        // Return the data using Inertia
        return Inertia::render('Public/Menus/Show', [
            'menu' => new PublicMenuResource($menu)
        ]);
    }
}
