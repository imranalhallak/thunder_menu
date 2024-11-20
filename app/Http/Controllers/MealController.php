<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMealRequest;
use App\Http\Requests\UpdateMealRequest;
use App\Http\Resources\MealResource;
use App\Models\Branch;
use App\Models\Menu;
use App\Models\Meal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MealController extends Controller
{
    // Display a listing of the meals.
    public function index(Request $request)
    {
        $branchId = auth()->user()->default_branch; // Replace with the actual branch ID
        $menuId = $request->query('menu_id'); // Get the optional menu_id from the URL

        $allMeals = Meal::search($request);

        // Filter meals based on menu and branch
        $filteredMeals = $allMeals->whereHas('menu', function ($query) use ($branchId, $menuId) {
            // Filter by branch
            $query->whereHas('branch', function ($query) use ($branchId) {
                $query->where('id', $branchId);
            });

            // Filter by menu if menuId is provided
            if ($menuId) {
                $query->where('id', $menuId);
            }
        });

        // Paginate the filtered meals
        $meals = MealResource::collection($filteredMeals->paginate(10));

        return Inertia::render('Meals/Index', [ // Render the Inertia Vue component
            'meals' => $meals,
            'filters' => [
                'menu_id' => $menuId, // Include menu_id in the filters, if needed in the frontend
            ],
        ]);
    }

    // Store a newly created meal in storage.
    public function create(?Branch $branchId)
    {
        $menus = Branch::find(auth()->user()->default_branch)->menus;
        return Inertia::render('Meals/Create', [
            'menus' => $menus
        ]);
    }

    // Store the meal data
    public function store(StoreMealRequest $request)
    {
        // Validate the request
        $validated = $request->validated();

        // Handle image file upload
        if ($request->hasFile('image')) {
            // Store the image in 'meal_images' directory under public storage
            $validated['image'] = $request->file('image')->store('meal_images', 'public');
        } elseif ($request->hasFile('images')) {
            // Handle multiple images
            $imagePaths = []; // Initialize an empty array to store image paths.

            foreach ($request->file('images') as $image) {
                // Store the image and get its path
                $imagePath = $image->store('meal_images', 'public'); // Specify your directory
                $image->move('meal_images', $imagePath);

                $imagePaths[] = $imagePath; // Add the path to the array
            }

            // Convert array to JSON string and save in validated data
            $validated['images'] = json_encode($imagePaths);
        } else {
            // If no image is provided, return back with an error message
            return redirect()->back()->withErrors(['image' => 'Image upload is required.']);
        }

        // Add branch ID to the validated data
        $validated['branch_id'] = auth()->user()->default_branch;

        // Create a new meal with the validated data
        $meal = Meal::create($validated);

        // If there's a single image, save its path
        if (isset($validated['image'])) {
            $meal->image = $validated['image'];
        }

        // If there are multiple images, save their paths as a JSON string
        if (isset($validated['images'])) {
            $meal->images = $validated['images'];
        }

        // Save the meal instance
        $meal->save();

        // Redirect to the meals index page after creation
        return redirect()->route('meals.index');
    }




    // Display the specified meal.
    public function show(int $id): JsonResponse
    {
        $meal = Meal::findOrFail($id);
        return response()->json($meal);
    }

    // Display the edit form for a meal.
    public function edit($id)
    {
        $menus = Branch::find(auth()->user()->default_branch)->menus;
        $meal = Meal::where('id', $id)->first();

        return Inertia::render('Meals/Edit', [
            'meal' => $meal,
            'menus' => $menus,
        ]);
    }

    // Update the specified meal in storage.
    public function update(UpdateMealRequest $request, int $id)
    {
        // Validate request inputs
        $request->validated();

        // Find the meal by ID
        $meal = Meal::findOrFail($id);

        // Initialize or retrieve existing images
        $imagePaths = $meal->images ? json_decode($meal->images, true) : [];

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Store the image in the 'public/meal_images' directory
                $imagePath = $image->store('meal_images', 'public');
                $image->move('meal_images', $imagePath);

                $imagePaths[] = $imagePath; // Add the path to the array
            }
        }

        // Update the meal's attributes
        $meal->update([
            'menu_id' => $request->menu_id,
            'notebook_size' => $request->notebook_size, // Adjust or remove if not applicable
            'price_1' => $request->price_1, // Adjust or remove if not applicable
            'price_2' => $request->price_2, // Adjust or remove if not applicable
            'price_3' => $request->price_3, // Adjust or remove if not applicable
            'arabic_name' => $request->arabic_name, // Adjust or remove if not applicable
            'turkish_name' => $request->turkish_name, // Adjust or remove if not applicable
            'english_name' => $request->english_name, // Adjust or remove if not applicable
            'arabic_desicription' => $request->arabic_desicription, // Adjust or remove if not applicable
            'english_description' => $request->english_description, // Adjust or remove if not applicable
            'turkish_description' => $request->turkish_description, // Adjust or remove if not applicable
            'images' => !empty($imagePaths) ? json_encode($imagePaths) : $meal->images, // Retain current images if none are uploaded
            'updated_at' => now(),
        ]);

        // Redirect back to the edit page with success message
        return redirect()->route('meals.edit', $id)->with('success', 'Meal updated successfully!');
    }


    // Remove the specified meal from storage.
    public function destroy(int $id)
    {
        $meal = Meal::findOrFail($id);
        $meal->delete();

        return redirect()->route('meals.index');
    }
    public function deleteImage(Request $request, $id)
    {

        $product = Meal::findOrFail($id);


        // Update the product's images field with the remaining images
        $product->images = $request->images;
        $product->save();

        // Return a response (adjust as needed for your frontend)
        return redirect()->back()->with('success', 'Image deleted successfully!');
    }
    public function orderImage(Request $request, $id)
    {

        $product = Meal::findOrFail($id);


        // Update the product's images field with the remaining images
        $product->images = $request->images;
        $product->save();

        // Return a response (adjust as needed for your frontend)
        return redirect()->back()->with('success', 'Images ordered successfully!');
    }


    // Helper method to handle image uploads
    private function handleImageUploads($images)
    {
        $paths = [];
        if ($images) {
            foreach ($images as $file) {
                $paths[] = $file->store('meal_images', 'public');
            }
        }
        return $paths;
    }
}
