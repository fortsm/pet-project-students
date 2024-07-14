<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLectureRequest;
use App\Http\Requests\UpdateLectureRequest;
use App\Http\Resources\LectureCollection;
use App\Http\Resources\LectureDetailResource;
use App\Models\Lecture;
use App\Traits\HasJsonNotFoundRosource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    use HasJsonNotFoundRosource;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): LectureCollection
    {
        return new LectureCollection(Lecture::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLectureRequest $request): JsonResponse
    {
        $validated = $request->validated();
        Lecture::create($validated);
        return response()->json('Лекция добавлена', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): LectureDetailResource
    {
        $lecture = Lecture::find($id);
        $this->checkFound($lecture, Lecture::class, 'Лекция');
        return new LectureDetailResource($lecture);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLectureRequest $request, int $id)
    {
        $lecture = Lecture::find($id);
        $this->checkFound($lecture, Lecture::class, 'Лекция');
        $validated = $request->validated();
        $lecture->fill($validated);
        $lecture->save();
        return response()->json('Лекция обновлена', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $lecture = Lecture::find($id);
        $this->checkFound($lecture, Lecture::class, 'Лекция');
        $lecture->delete();
        return response()->json('Лекция успешно удалена', 200);
    }
}
