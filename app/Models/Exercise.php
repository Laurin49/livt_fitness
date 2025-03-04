<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function workouts(): BelongsToMany {
        return $this->belongsToMany(Workout::class)->withPivot('beschreibung');
    }

    public function scopeSearch(Builder $query, Request $request) {
        return $query->where(function ($query) use ($request) {
            
            return $query->when($request->search, function ($query) use ($request) {
                return $query->where(function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                });
            })->when($request->category_id, function ($query) use ($request) {
                return $query->where('category_id', $request->category_id);
            });
            
        });
    }
}
