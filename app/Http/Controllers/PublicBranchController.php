<?php

namespace App\Http\Controllers;

use App\Http\Resources\PublicMealResource;
use App\Http\Resources\PublicMenuResource;
use App\Models\Branch;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicBranchController extends Controller
{

    public function show($slug)
    {
        // Find the branch by its slug, eager load the menus and meals
        $selectedBranch = Branch::where('slug', $slug)
            ->with(['menus.meals' => function ($query) {
                $query->orderBy('position', 'asc'); // Order meals by position
            }])
            ->firstOrFail(); // Will throw a 404 if the branch is not found

        // Return the branch data using Inertia
        return Inertia::render('Public/Branches/Show', [
            'branch' => $selectedBranch, // You can directly pass it or format it using a resource
        ]);
    }




}
