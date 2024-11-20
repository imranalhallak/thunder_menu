<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DefaultController extends Controller
{
    public function index()
    {
        $branches = auth()->user()->branches()->orderBy('created_at', 'desc')->get();


        // Share the branch_id globally
        return Inertia::render('Dashboard', [
            'branches' => $branches,
        ]); // 'null' by default if not set
    }
    public function setBranch(Request $request)
    {
        // Set the global branch_id in session
        session(['branch_id' => $request->branch_id]);

        return redirect('admin');  // or return an Inertia response
        // Or return an Inertia page if needed
    }
}
