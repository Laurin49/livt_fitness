<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExerciseRequest;
use App\Http\Resources\ExerciseResource;
use App\Models\Exercise;
use Inertia\Inertia;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Fitness/Exercises/ExerciseIndex', [
            'exercises' => ExerciseResource::collection(Exercise::all())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Fitness/Exercises/Create');
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
        return Inertia::render('Fitness/Exercises/Edit', [
            'exercise' => new ExerciseResource($exercise)
        ]);
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
