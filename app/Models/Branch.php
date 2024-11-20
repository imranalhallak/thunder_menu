<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_id',
        'slogan',
        'phone',
        'address1',
        'address2',
        'location',
        'slug',
        'image',
        'logo',
        'mode',
        'facebook',
        'instagram',
        'whatsapp',
    ];

    /**
     * Relationships: A branch belongs to a user and has many menus.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
