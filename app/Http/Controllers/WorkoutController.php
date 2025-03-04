<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkoutRequest;
use App\Http\Requests\UpdateWorkoutRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ExerciseResource;
use App\Http\Resources\ExerciseWorkoutResource;
use App\Http\Resources\WorkoutResource;
use App\Models\Category;
use App\Models\Exercise;
use App\Models\ExerciseWorkout;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class WorkoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $workoutQuery = Workout::search($request);

        $workouts = WorkoutResource::collection($workoutQuery->with('category')->latest()->paginate(10));
        $categories = CategoryResource::collection(Category::all());

        return Inertia::render('Fitness/Workouts/WorkoutIndex', [
            'workouts' => $workouts,
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
        return Inertia::render('Fitness/Workouts/Create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkoutRequest $request)
    {
        Workout::create($request->validated());
        return redirect()->route('workouts.index')->with('success', 'Workout created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Workout $workout)
    {
        $current_workout = new WorkoutResource($workout->load('category'));

        $all_exercises = $workout->category->exercises;
        $workout->exercises = ExerciseResource::collection($workout->exercises->load('category'));
        $available_exercises = $all_exercises->whereNotIn('name', $workout->exercises->pluck('name')->toArray())->all();

        $pivot_exercises_workouts = ExerciseWorkoutResource::collection($workout->exercise_workout->load('workout', 'exercise'));

        return Inertia::render('Fitness/Workouts/Show', [
            'workout' => $current_workout,
            'workout_exercises' => $workout->exercises,
            'available_exercises' => $available_exercises,
            'pivot_exercises_workouts' => $pivot_exercises_workouts,
        ]);
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
        return redirect()->route('workouts.index')->with('success', 'Workout updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workout $workout)
    {
        $workout->delete();
        return redirect()->route('workouts.index')->with('success', 'Workout deleted successfully');
    }

    public function attachExercise(Request $request, Workout $workout)
    {
        // dd($request);
        $request->validate([
            'attach_exercise_id' => 'required',
            'beschreibung' => 'required',
        ]);
        $workout->exercises()->attach($request->attach_exercise_id, ['beschreibung' => $request->beschreibung]);

        $this->show($workout);
    }

    public function detachExercise(Request $request, Workout $workout)
    {
        $workout->exercises()->detach($request->detach_exercise_id);

        $this->show($workout);
    }

    public function copy_workout(Workout $workout)
    {
        $curr_workout = Workout::create([
            'name' => $workout->name,
            'datum' => now(),
            'category_id' => $workout->category_id,
            'user_id' => $workout->user_id
        ]);

        foreach ($workout->exercises as $key => $curr_exercise) {
            $curr_workout->exercises()->attach($curr_exercise->id, ['beschreibung' => $curr_exercise->pivot->beschreibung]);
        }
        return redirect()->route('workouts.index')->with('success', 'Workout copied successfully');
    }

    public function updateBeschreibung(Request $request, Workout $workout, Exercise $exercise)
    {
        $exercise_id = $request->currentExerciseId;
        $beschreibung = $request->currentBeschreibung;
        // dd($workout);

        $workout->exercises()->updateExistingPivot($exercise_id, ['beschreibung' => $beschreibung]);

        $this->show($workout);
    }
}
