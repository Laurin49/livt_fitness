<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExerciseRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ExerciseResource;
use App\Models\Category;
use App\Models\Exercise;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $exerciseQuery = Exercise::search($request);

        $exercises = ExerciseResource::collection($exerciseQuery->with('category')->paginate(10));
        $categories = CategoryResource::collection(Category::all());

        return Inertia::render('Fitness/Exercises/ExerciseIndex', [
            'exercises' => $exercises,
            'categories' => $categories,
            'category_id' => $request->category_id ?? '',
            'search' => $request->search ?? '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = CategoryResource::collection(Category::all());
        return Inertia::render('Fitness/Exercises/Create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExerciseRequest $request)
    {
        Exercise::create($request->validated());
        return redirect()->route('exercises.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Exercise $exercise)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exercise $exercise)
    {
        $categories = CategoryResource::collection(Category::all());
        return Inertia::render('Fitness/Exercises/Edit', 
            compact('exercise', 'categories')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreExerciseRequest $request, Exercise $exercise)
    {
        $exercise->update($request->validated());
        return redirect()->route('exercises.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exercise $exercise)
    {
        $exercise->delete();
        return redirect()->route('exercises.index');  
    }
}
