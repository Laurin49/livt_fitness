<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'datum', 'category_id', 'user_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function exercises(): BelongsToMany {
        return $this->belongsToMany(Exercise::class)->withPivot('beschreibung');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function exercise_workout()
    {
        return $this->hasMany(ExerciseWorkout::class);
    }   
    
    public function scopeSearch(Builder $query, Request $request)
    {
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
