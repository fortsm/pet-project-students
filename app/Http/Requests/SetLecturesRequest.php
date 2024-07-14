<?php

namespace App\Http\Requests;

use App\Models\Curriculum;
use App\Traits\HasJsonFailedValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SetLecturesRequest extends FormRequest
{
    use HasJsonFailedValidation;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function validated($key = null, $default = null): array
    {
        $classroom_id = (int) $this->route('id');
        $lectures = $this->input();
        if (!is_array($lectures)) {
            $this->error('Укажите массив лекций');
        }

        if (!empty(array_diff_assoc($lectures, array_unique($lectures)))) {
            $this->error("Лекции должны быть в разные дни");
        }

        foreach ($lectures as $lecture_id => $date) {
            $lecture_exists = Curriculum::where([
                    ['audition_date', '=', $date],
                    ['lecture_id', '=', $lecture_id],
                    ['classroom_id', '!=', $classroom_id],
                ])
                ->count();

            if ($lecture_exists) {
                /**
                 * Согласно заданию "Разные классы проходят лекции в разном порядке"
                 */
                $this->error("Лекция $lecture_id в дату $date уже есть у другого класса");
            }
        }
        return $lectures;
    }

    /**
     * Throws error with specified msg
     */
    public function error(string $msg): void
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => $msg,
        ], 400));
    }
}
