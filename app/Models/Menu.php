<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Builder;
class Menu extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'image',
        'slug',
        'arabic_name',
        'english_name',
        'turkish_name',
        'branch_id',
    ];

    /**
     * Relationships: A menu belongs to a branch and has many meals.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function meals()
    {
        return $this->hasMany(Meal::class);
    }
    public function scopeSearch(Builder $query, Request $request)
    {
        return $query->where(function ($query) use ($request) {
            return $query->when($request->search, function ($query) use ($request) {
                return $query->where(function ($query) use ($request) {
                    $query->where('arabic_name', 'like', '%' . $request->search . '%')
                        ->orWhere('english_name', 'like', '%' . $request->search . '%')
                        ->orWhere('turkish_name', 'like', '%' . $request->search . '%')
                        ;
                });
            })->when($request->branch_id, function ($query) use ($request) {
                return $query->where('branch_id', $request->branch_id);
            });
        });
    }
}
