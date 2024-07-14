<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentCollection;
use App\Http\Resources\StudentDetailResource;
use App\Models\Student;
use App\Traits\HasJsonNotFoundRosource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    use HasJsonNotFoundRosource;

    /**
     * Display a list of students.
     */
    public function index(Request $request): StudentCollection
    {
        return new StudentCollection(Student::paginate(10));
    }

    /**
     * Display the specified student.
     */
    public function show(int $id): StudentDetailResource|JsonResponse
    {
        $student = Student::find($id);
        $this->checkFound($student, Student::class, 'Студент');
        return new StudentDetailResource($student);
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
        $student = Student::find($id);
        $this->checkFound($student, Student::class, 'Студент');
        $validated = $request->validated();
        $student->fill($validated);
        $student->save();
        return response()->json('Студент обновлен', 200);
    }

    /**
     * Remove the specified student from database.
     */
    public function destroy(int $id): JsonResponse
    {
        $student = Student::find($id);
        $this->checkFound($student, Student::class, 'Студент');
        $student->delete();
        return response()->json('Студент успешно удален', 200);
    }
}
