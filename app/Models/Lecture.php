<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lecture extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'subject',
        'description',
    ];

    /**
     * The classrooms that belong to the lecture.
     */
    public function classrooms(): BelongsToMany
    {
        return $this->belongsToMany(Classroom::class, 'curriculums');
    }

    /**
     * The attended classrooms that belong to the lecture.
     */
    public function attended_classrooms(): BelongsToMany
    {
        return $this->classrooms()
            ->wherePivot('audition_date', '<', date('Y-m-d'));
    }

    /**
     * The attended students that belong to the lecture.
     */
    public function attended_students(): Collection
    {
        return Student::whereIn('classroom_id', $this->attended_classrooms()->pluck('classrooms.id'))
            ->get();
    }
}
