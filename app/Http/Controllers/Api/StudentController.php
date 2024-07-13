<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a list of students.
     */
    public function index(Request $request): JsonResponse
    {
        $students = Student::query()->get();

        return response()->json($students, 200);
    }

    /**
     * Display the specified student.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $student = Student::with('classroom.attended_lectures')->findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                'success'   => false,
                'message'   => 'Студент не найден',
            ], 404);
        }
        return response()->json($student, 200);
    }

    /**
     * Store a newly created student in database.
     */
    public function store(StoreStudentRequest $request): JsonResponse
    {
        $validated = $request->validated();
        Student::create($validated);
        return response()->json('Студент добавлен', 200);
    }

    /**
     * Update the specified student.
     */
    public function update(UpdateStudentRequest $request, int $id): JsonResponse
    {
        try {
            $student = Student::findOrFail($id);
            $validated = $request->validated();
            $student->fill($validated);
            $student->save();
        } catch (Exception $e) {
            return response()->json([
                'success'   => false,
                'message'   => "Ошибка обновления студента: {$e->getMessage()}",
            ], 404);
        }
        return response()->json('Студент обновлен', 200);
    }

    /**
     * Remove the specified student from database.
     */
    public function destroy(int $id): JsonResponse
    {
        $student = Student::find($id);
        if (!($student instanceof Student)) {
            return response()->json([
                'success'   => false,
                'message'   => 'Студент не найден',
            ], 404);
        }
        $student->delete();
        return response()->json([
            'success'   => true,
            'message'   => 'Студент успешно удален',
        ], 200);
    }
}
