<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Builder;

class Meal extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'price_1',
        'price_2',
        'price_3',
        'arabic_name',
        'english_name',
        'turkish_name',
        'arabic_description',
        'english_description',
        'turkish_description',
        'images',
        'menu_id',
        'branch_id',
    ];

    /**
     * Relationships: A meal belongs to a menu.
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
     // Scope for search functionality
     public function scopeSearch(Builder $query, Request $request)
     {
         return $query->where(function ($query) use ($request) {
             return $query->when($request->search, function ($query) use ($request) {
                 return $query->where(function ($query) use ($request) {
                     $query->where('arabic_name', 'like', '%' . $request->search . '%')
                         ->orWhere('arabic_description', 'like', '%' . $request->search . '%')
                         ->orWhere('english_description', 'like', '%' . $request->search . '%')
                         ->orWhere('english_name', 'like', '%' . $request->search . '%')
                         ->orWhere('turkish_description', 'like', '%' . $request->search . '%')
                         ->orWhere('turkish_name', 'like', '%' . $request->search . '%')
                         ->orWhereHas('menu', function ($menuQuery) use ($request) {
                             // Search within menus
                             $menuQuery->where('name', 'like', '%' . $request->search . '%')
                                 ->orWhereHas('branch', function ($branchQuery) use ($request) {
                                     // Search within branches
                                     $branchQuery->where('name', 'like', '%' . $request->search . '%');
                                 });
                         });
                 });
             });
         });
     }
}
