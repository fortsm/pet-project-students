<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SetLecturesRequest;
use App\Http\Requests\StoreClassroomRequest;
use App\Http\Requests\UpdateClassroomRequest;
use App\Models\Classroom;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the classrooms.
     */
    public function index(Request $request): JsonResponse
    {
        $classrooms = Classroom::query()->get();
        return response()->json($classrooms, 200);
    }

    /**
     * Display the specified classroom with students.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $classroom = Classroom::with('students')->findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                'success'   => false,
                'message'   => 'Класс не найден',
            ], 404);
        }
        return response()->json($classroom, 200);
    }

    /**
     * Display the specified classroom with lectures.
     */
    public function lectures(int $id): JsonResponse
    {
        try {
            $classroom = Classroom::with('lectures')
                ->findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                'success'   => false,
                'message'   => 'Класс не найден',
            ], 404);
        }
        return response()->json($classroom, 200);
    }

    /**
     * Attach or detach lectures from/to classrom.
     */
    public function setlectures(SetLecturesRequest $request, int $id): JsonResponse
    {
        /**
         * Исходя из задания предполагаю, что создание и обновление расписания
         * должно быть выполнено одним запросом, путем прикрепления имеющихся
         * лекций к классу через промежуточную таблицу, а не путем добавления
         * каждой отдельной строки в БД.
         */
        try {
            $lectures = $request->validated();
            $classroom = Classroom::findOrFail($id);
            $curriculum = [];
            foreach ($lectures as $lecture_id => $date) {
                $curriculum[$lecture_id] = ['audition_date' => $date];
            }
            $classroom->lectures()->sync($curriculum);
        } catch (Exception $e) {
            return response()->json([
                'success'   => false,
                'message'   => "Ошибка при создании/редактировании расписания лекций: {$e->getMessage()}",
            ], 400);
        }
        return response()->json('Расписание обновлено', 200);
    }

    /**
     * Store a newly created Classroom in database.
     */
    public function store(StoreClassroomRequest $request): JsonResponse
    {
        $validated = $request->validated();
        Classroom::create($validated);
        return response()->json('Класс добавлен', 200);
    }

    /**
     * Update the specified Classroom.
     */
    public function update(UpdateClassroomRequest $request, int $id): JsonResponse
    {
        try {
            $classroom = Classroom::findOrFail($id);
            $validated = $request->validated();
            $classroom->fill($validated);
            $classroom->save();
        } catch (Exception $e) {
            return response()->json([
                'success'   => false,
                'message'   => "Ошибка обновления класса: {$e->getMessage()}",
            ], 404);
        }
        return response()->json('Класс обновлен', 200);
    }

    /**
     * Remove the specified Classroom from database.
     */
    public function destroy(int $id): JsonResponse
    {
        $classroom = Classroom::find($id);
        if (!($classroom instanceof Classroom)) {
            return response()->json([
                'success'   => false,
                'message'   => 'Класс не найден',
            ], 404);
        }
        $classroom->delete();
        return response()->json([
            'success'   => true,
            'message'   => 'Класс успешно удален',
        ], 200);
    }
}
