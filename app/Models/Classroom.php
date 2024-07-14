<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classroom extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The students that belong to the classroom.
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    /**
     * The lectures that belong to the classroom.
     */
    public function lectures(): BelongsToMany
    {
        return $this->belongsToMany(Lecture::class, 'curriculums')
            ->withPivot('audition_date')
            ->withTimestamps();
    }

    /**
     * The attended lectures that belong to the classrom.
     */
    public function attended_lectures(): BelongsToMany
    {
        return $this->lectures()
            ->wherePivot('audition_date', '<', date('Y-m-d'));
    }
}
