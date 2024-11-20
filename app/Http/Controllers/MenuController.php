<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Meal;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Http\Resources\MenuResource;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    // Display a listing of the menus (Inertia response).
    public function index(Request $request)
    {
        $menusQuery = Menu::search($request);

        $allMenus = MenuResource::collection($menusQuery->where('branch_id', auth()->user()->default_branch)->paginate(10));
        return Inertia::render('Menus/Index', [ // Render the Inertia Vue component
            'menus' => $allMenus
        ]);
    }

    public function test(Request $request)
    {
        $menusQuery = Menu::search($request);

        $allMenus = MenuResource::collection($menusQuery->where('branch_id', auth()->user()->default_branch)->paginate(10));
        return Inertia::render('Test/Test', [ // Render the Inertia Vue component
            'menus' => $allMenus
        ]);
    }

    // Display the create form for a menu.
    public function create()
    {
        return Inertia::render('Menus/Create');
    }

    // Store a newly created menu in storage.
    public function store(StoreMenuRequest $request)
    {
        if ($request->hasFile('image')) {
            // Store the image in 'public/images' and get the relative path
            $validated['image'] = $request->file('image')->store('menu_images', 'public');
        }
        $baseSlug = Str::slug($request['name']);

        // Ensure slug uniqueness by appending a number
        $slug = $baseSlug;
        $count = 1;
        while (Menu::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '' . $count;
            $count++;
        }
        $data = $request->validated();
        $data['branch_id'] = auth()->user()->default_branch;
        $data['slug'] = $slug;
        $menu = Menu::create($data); // Create a new menu

        $request->file('image')->move('menu_images', $validated['image']);
        $menu->image = $validated['image'];
        $menu->save();

        return redirect()->route('menus.index'); // Redirect to the index page after creation
    }

    // Display the specified menu.
    public function show($id)
    {
        $menu = Menu::findOrFail($id); // Find the menu by ID
        return Inertia::render('Menus/Show', [
            'menu' => $menu
        ]);
    }

    // Display the edit form for a menu.
    public function edit($id)
    {
        $menu = Menu::where('id', $id)->first(); // Will return the first match
        return Inertia::render('Menus/Edit', [
            'menu' => $menu,
        ]);
    }

    // Update the specified menu in storage.
    public function update(UpdateMenuRequest $request, $id)
    {
        $menu = Menu::findOrFail($id);

        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            ]);

            // Store the image in 'public/images' and get the relative path
            $validated['image'] = $request->file('image')->store('menu_images', 'public');
        }

        $menu->update($request->validated());
        if ($request->hasFile('image')) {
            $request->file('image')->move('menu_images', $validated['image']);
            $menu->image = $validated['image'];
            $menu->save();
        }

        return redirect()->route('menus.index')->with('success', 'Menu updated successfully!');
    }

    // Remove the specified menu from storage.
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete(); // Delete the menu
        return redirect()->route('menus.index'); // Redirect to the index page after deletion
    }
}
