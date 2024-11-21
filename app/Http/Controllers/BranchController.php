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
            // Get the uploaded file
            $image = $request->file('image');

            // Generate a unique name for the image

            // Define the path to the public folder
            $destinationPath = public_path('branch_images'); // e.g., /public/uploads
            $path = $request->file('image')->store('branch_images', 'public');

            // Move the file to the public/uploads folder
            $image->move($destinationPath, $path);

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
    public function update(UpdateBranchRequest $request, $id)
    {
        // Get validated data from the request
        if (!$request->validated()) {
            return redirect()->route('menus.index')
                ->with('success', 'Branch updated successfully.');
        }
        $validatedData = $request->validated();
        $branch = Branch::findOrFail($id);
        // Check if the name has been updated to regenerate the slug
        if ($validatedData['name'] !== $branch->name) {
            $baseSlug = Str::slug($validatedData['name']);
            $slug = $baseSlug;
            $count = 1;

            // Ensure the slug is unique by appending a number if necessary
            while (Branch::where('slug', $slug)->where('id', '!=', $branch->id)->exists()) {
                $slug = $baseSlug . '-' . $count;
                $count++;
            }
            $validatedData['slug'] = $slug; // Assign the new slug to the validated data
            $validatedData['user_id'] = auth()->user()->id; // Assign the new slug to the validated data
        }

        // Update the branch details
        $branch->update($validatedData);

        // Handle logo upload if present
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('branch_logos', 'public');
            $branch->logo = $path;  // Save the path to the logo field
            $branch->save();
        }

        // Handle image upload if present
        if ($request->hasFile('image')) {
            // Get the uploaded file
            $image = $request->file('image');
            // Generate a unique filename
            $uniqueFilename = Str::random(40) . '.' . $image->getClientOriginalExtension();
            // Move the file to the public/uploads folder
            $path =   $image->move('branch_images', $uniqueFilename);
            $branch->image = $path;
            $branch->save();
        }

        // Redirect back with a success message
        return redirect()->route('menus.index')
            ->with('success', 'Branch updated successfully.');
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
