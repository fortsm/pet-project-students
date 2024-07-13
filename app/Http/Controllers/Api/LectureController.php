<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLectureRequest;
use App\Http\Requests\UpdateLectureRequest;
use App\Models\Lecture;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $lectures = Lecture::query()->get();

        return response()->json($lectures, 200);
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
    public function show(int $id): JsonResponse
    {
        try {
            $lecture = Lecture::with(['attended_classrooms', 'attended_classrooms.students'])
                ->findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                'success'   => false,
                'message'   => 'Лекция не найдена',
            ], 404);
        }
        return response()->json($lecture, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLectureRequest $request, int $id)
    {
        try {
            $lecture = Lecture::findOrFail($id);
            $validated = $request->validated();
            $lecture->fill($validated);
            $lecture->save();
        } catch (Exception $e) {
            return response()->json([
                'success'   => false,
                'message'   => "Ошибка обновления лекции: {$e->getMessage()}",
            ], 404);
        }
        return response()->json('Лекция обновлена', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $lecture = Lecture::find($id);
        if (!($lecture instanceof Lecture)) {
            return response()->json([
                'success'   => false,
                'message'   => 'Лекция не найдена',
            ], 404);
        }
        $lecture->delete();
        return response()->json([
            'success'   => true,
            'message'   => 'Лекция успешно удалена',
        ], 200);
    }
}
