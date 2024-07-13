<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        // Получаем фильтры из запроса
        $filters = $request->all();

        // Формируем SQL запрос
        $query = Curriculum::query();

        foreach ($filters as $key => $value) {
            match ($key) {
                'classroom_id' => $query->with('classrooms')->where('classroom_id', $filters['classroom_id']),
                default => null,
            };
        }

        $data = $query->get();

        return response()->json($data, 200);
    }
}
