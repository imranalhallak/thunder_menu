<?php

namespace App\Http\Controllers;

use App\Http\Resources\PublicMealResource;
use App\Models\Branch;
use App\Models\Meal;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicMealController extends Controller
{
    public function show($branch, $menu, $meal)
    {
        // Load the branch, with menus and their meals
        $meal = Meal::with('menu')->findOrFail($meal);

        // Fetch the logo of the branch associated with the meal's menu
        $logo = Branch::where('id', $meal->menu->branch_id)->first()->logo;

        // Return the data using Inertia
        return Inertia::render('Public/Meals/Show', [
            'meal' => $meal,
            'logo' => $logo
        ]);
    }
}
