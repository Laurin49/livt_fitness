<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkoutRequest;
use App\Http\Requests\UpdateWorkoutRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\WorkoutResource;
use App\Models\Category;
use App\Models\Workout;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WorkoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Fitness/Workouts/WorkoutIndex', [
            'workouts' => WorkoutResource::collection(Workout::with('category')->paginate(10))
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = CategoryResource::collection(Category::all());
        return Inertia::render('Fitness/Workouts/Create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkoutRequest $request)
    {
        Workout::create($request->validated());
        return redirect()->route('workouts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Workout $workout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Workout $workout)
    {
        $categories = CategoryResource::collection(Category::all());
        return Inertia::render(
            'Fitness/Workouts/Edit', compact('workout', 'categories')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkoutRequest $request, Workout $workout)
    {
        $workout->update($request->validated());
        return redirect()->route('workouts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workout $workout)
    {
        $workout->delete();
        return redirect()->route('workouts.index'); 
    }
}
