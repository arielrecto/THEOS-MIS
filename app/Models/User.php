<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    public function teacherClassrooms()
    {
        return $this->hasMany(Classroom::class, 'teacher_id');
    }
    public function asStudentClassrooms()
    {
        return $this->hasMany(ClassroomStudent::class, 'student_id');
    }
    public function attendances()
    {
        return $this->hasMany(AttendanceStudent::class);
    }
    public function tasks()
    {
        return $this->hasMany(StudentTask::class);
    }
    public function overallGrade()
    {

        $studentTasks = $this->tasks;


        $totalScore = $studentTasks->sum('score');
        $totalMaxScore = $studentTasks->sum(fn ($task) => $task->task->max_score);


        if ($totalMaxScore == 0) {
            return 0;
        }


        return round(($totalScore / $totalMaxScore) * 100, 2);
    }

    public function enrollmentForms()
    {
        return $this->hasMany(EnrollmentForm::class);
    }

    public function generalAnnouncements()
    {
        return $this->hasMany(GeneralAnnouncement::class);
    }

    public function graded()
    {
        return $this->hasMany(Grade::class, 'created_by');
    }

    public function overAllAverageTaskByClassroom( $classroom_id) : float|int
    {

        $studentTask = StudentTask::whereHas('task', function ($query) use ($classroom_id) {
            $query->where('classroom_id', $classroom_id);
        })->where('user_id', $this->id)->get();


        $average  = 0;

        $totalCount = count($studentTask);


        foreach ($studentTask as $task) {
            $average += $task->getScorePercentageAttribute();
        }


        return round($average / $totalCount, 2);
    }

    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function comments()
    {
        return $this->hasManyMorph(Comment::class, 'commentable');
    }
}
