<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBranchRequest $request)
    {
        // Get validated data from the request
        $validatedData = $request->validated();

        // Generate a base slug from the name
        $baseSlug = Str::slug($validatedData['name']);

        // Ensure the slug is unique by appending a number if necessary
        $slug = $baseSlug;
        $count = 1;
        while (Branch::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count;  // Use a hyphen instead of an empty string for better readability
            $count++;
        }

        // Create the branch with the validated data
        $branch = Branch::create([
            'name' => $validatedData['name'],
            'slogan' => $validatedData['slogan'],
            'whatsapp' => $validatedData['whatsapp'],
            'instagram' => $validatedData['instagram'],
            'facebook' => $validatedData['facebook'],
            'phone' => $validatedData['phone'],
            'location' => $validatedData['location'],
            'address1' => $validatedData['address1'],
            'address2' => $validatedData['address2'],
            'slug' => $slug,
            'user_id' => auth()->id(),  // Assign the currently authenticated user
            'logo' => null,  // Initialize logo as null
            'image' => null, // Initialize image as null
        ]);

        // Handle logo upload if present
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('branch_logos', 'public');
            $branch->logo = $path;  // Save the path to the logo field
            $branch->save();
        }

        // Handle image upload if present
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('branch_images', 'public');
            $branch->image = $path;  // Save the path to the image field
            $branch->save();
        }

        // Redirect to the menus index route with a success message
        return redirect()->route('menus.index')
            ->with('success', 'Branch created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {


$branch = Branch::findOrFail($id);
        return Inertia::render('Branches/Edit', [
            'branch' => $branch,
        ]); // 'null' by default if not set
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBranchRequest $request, Branch $branch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        //
    }

    /**
     * Set the default branch for the authenticated user.
     */
    public function setBranch($id)
    {

        $user = auth()->user();
        $user->default_branch = $id;
        $user->save();

        return redirect('dashboard')->with('success', 'Default branch updated.');
    }
}
