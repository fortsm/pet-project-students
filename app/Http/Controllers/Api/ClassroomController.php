<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SetLecturesRequest;
use App\Http\Requests\StoreClassroomRequest;
use App\Http\Requests\UpdateClassroomRequest;
use App\Http\Resources\ClassroomCollection;
use App\Http\Resources\ClassroomDetailResource;
use App\Http\Resources\ClassroomWithLecturesResource;
use App\Models\Classroom;
use App\Traits\HasJsonNotFoundRosource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    use HasJsonNotFoundRosource;

    /**
     * Display a listing of the classrooms.
     */
    public function index(Request $request): ClassroomCollection
    {
        return new ClassroomCollection(Classroom::paginate(10));
    }

    /**
     * Display the specified classroom with students.
     */
    public function show(int $id): ClassroomDetailResource|JsonResponse
    {
        $classroom = Classroom::find($id);
        $this->checkFound($classroom, Classroom::class, 'Класс');
        return new ClassroomDetailResource($classroom);
    }

    /**
     * Display the specified classroom with lectures.
     */
    public function lectures(int $id): ClassroomWithLecturesResource
    {
        $classroom = Classroom::find($id);
        $this->checkFound($classroom, Classroom::class, 'Класс');
        return new ClassroomWithLecturesResource($classroom);
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
        $lectures = $request->validated();
        $classroom = Classroom::find($id);
        $this->checkFound($classroom, Classroom::class, 'Класс');
        $curriculum = [];
        foreach ($lectures as $lecture_id => $date) {
            $curriculum[$lecture_id] = ['audition_date' => $date];
        }
        $classroom->lectures()->sync($curriculum);
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
        $classroom = Classroom::find($id);
        $this->checkFound($classroom, Classroom::class, 'Класс');
        $validated = $request->validated();
        $classroom->fill($validated);
        $classroom->save();
        return response()->json('Класс обновлен', 200);
    }

    /**
     * Remove the specified Classroom from database.
     */
    public function destroy(int $id): JsonResponse
    {
        $classroom = Classroom::find($id);
        $this->checkFound($classroom, Classroom::class, 'Класс');
        $classroom->delete();
        return response()->json('Класс успешно удален', 200);
    }
}
