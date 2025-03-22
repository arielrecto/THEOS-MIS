<?php

use App\Models\StudentTask;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Admin\StrandController;
use App\Http\Controllers\Teacher\TaskController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Teacher\GradeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Teacher\ClassroomController;
use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Teacher\AttendanceController;
use App\Http\Controllers\Teacher\StudentTaskController;
use App\Http\Controllers\Registrar\EnrollmentController;
use App\Http\Controllers\Teacher\AnnouncementController;
use App\Http\Controllers\Admin\GeneralAnnouncementController;
use App\Http\Controllers\Teacher\ProfileController as TeacherProfileController;
use App\Http\Controllers\Teacher\StudentController as TeacherStudentController;
use App\Http\Controllers\EnrollmentController as ControllersEnrollmentController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Registrar\DashboardController as RegistrarDashboardController;
use App\Http\Controllers\Student\AnnouncementController as StudentAnnouncementController;
use App\Http\Controllers\Student\ClassroomController as StudentClassroomController;
use App\Http\Controllers\Student\TaskController as StudentTasksController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::get('/contact-us', [LandingPageController::class, 'contact'])->name('contact');
Route::get('/gallery', [LandingPageController::class, 'gallery'])->name('gallery');
Route::get('/about-us', [LandingPageController::class, 'about'])->name('about');
Route::get('/home', [HomeController::class, 'index'])
    ->name('home')
    ->middleware(['auth']);

Route::prefix('enrollment')
    ->as('enrollment.')
    ->group(function () {
        Route::get('/form', [ControllersEnrollmentController::class, 'form'])->name('form');
        Route::get('/{id}', [ControllersEnrollmentController::class, 'show'])->name('show');
        Route::post('/', [ControllersEnrollmentController::class, 'store'])->name('store');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:admin'])
        ->prefix('admin')
        ->as('admin.')
        ->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
            Route::prefix('users')
                ->as('users.')
                ->group(function () {
                    Route::get('', [UserController::class, 'index'])->name('index');
                    Route::resource('students', StudentController::class);
                    Route::resource('teacher', TeacherController::class);
                });
            Route::resource('strands', StrandController::class);
            Route::resource('subjects', SubjectController::class);
            Route::resource('academic-year', AcademicYearController::class);

            Route::prefix('general-announcements')
                ->as('general-announcements.')
                ->group(function () {
                    Route::put('/{id}/toggle', [GeneralAnnouncementController::class, 'toggle'])->name('toggle');
                });
            Route::resource('general-announcements', GeneralAnnouncementController::class);
        });

    Route::middleware(['role:teacher'])
        ->prefix('teacher')
        ->as('teacher.')
        ->group(function () {
            Route::middleware(['profile.first'])->group(function () {
                Route::get('/dashboard', [TeacherDashboardController::class, 'dashboard'])->name('dashboard');
                Route::prefix('classrooms')
                    ->as('classrooms.')
                    ->group(function () {
                        Route::get('/{classroom}/attendances', [AttendanceController::class, 'create'])->name('attendances');
                        Route::post('/attendances', [AttendanceController::class, 'store'])->name('attendances.store');
                        Route::get('/attendances/{attendance}/scanner', [AttendanceController::class, 'scanner'])->name('attendances.scanner');
                        Route::post('/attendances/student', [AttendanceController::class, 'studentAttendance'])->name('attendances.students');
                        Route::get('/{classroom}/student', [ClassroomController::class, 'students'])->name('students');
                        Route::delete('/student/{classroom_student}', [ClassroomController::class, 'removeStudent'])->name('student.remove');
                    });

                Route::prefix('student')
                    ->as('student.')
                    ->group(function () {
                        Route::get('/{student}', [TeacherStudentController::class, 'show'])->name('show');
                        Route::get('', [TeacherStudentController::class, 'index'])->name('index');
                    });

                Route::prefix('grades')
                    ->as('grades.')
                    ->group(function () {
                        Route::get('', [GradeController::class, 'index'])->name('index');

                        Route::post('', [GradeController::class, 'store'])->name('store');
                        Route::post('/individual', [GradeController::class, 'storeIndividual'])->name('store.individual');
                    });

                Route::prefix('student-task')
                    ->as('studentTask.')
                    ->group(function () {
                        Route::get('{student_task}', [StudentTaskController::class, 'show'])->name('show');
                        Route::post('{student_task}/add-score', [StudentTaskController::class, 'addScore'])->name('addScore');
                    });

                Route::prefix('announcements')
                    ->as('announcements.')
                    ->group(function () {
                        Route::get('remove-file', [AnnouncementController::class, 'removeFile'])->name('remove-file');
                    });

                Route::resource('classrooms', ClassroomController::class);
                Route::resource('announcements', AnnouncementController::class);
                Route::resource('tasks', TaskController::class);
            });

            Route::resource('profile', TeacherProfileController::class)->except('index');
        });

    Route::middleware(['role:registrar'])
        ->prefix('registrar')
        ->as('registrar.')
        ->group(function () {
            Route::get('/dashboard', [RegistrarDashboardController::class, 'dashboard'])->name('dashboard');
            Route::prefix('enrollments')
                ->as('enrollments.')
                ->group(function () {
                    Route::get('/form/{id}', [EnrollmentController::class, 'showEnrollee'])->name('showEnrollee');
                    Route::put('/form/{id}', [EnrollmentController::class, 'enrolled'])->name('enrolled');
                });
            Route::resource('enrollments', EnrollmentController::class);
        });

    Route::middleware(['role:student'])
        ->prefix('student')
        ->as('student.')
        ->group(function () {
            Route::get('/dashboard', [StudentDashboardController::class, 'dashboard'])->name('dashboard');
            Route::prefix('announcements')
                ->as('announcements.')
                ->group(function () {
                    Route::get('', [StudentAnnouncementController::class, 'index'])->name('index');
                    Route::get('{id}', [StudentAnnouncementController::class, 'show'])->name('show');
                });
            Route::prefix('classrooms')
                ->as('classrooms.')
                ->group(function () {
                    Route::get('', [StudentClassroomController::class, 'index'])->name('index');
                    Route::get('{classroom}', [StudentClassroomController::class, 'show'])->name('show');
                    Route::get('{classroom}/attendances', [StudentClassroomController::class, 'attendances'])->name('attendances');
                    Route::post('{classroom}/join', [StudentClassroomController::class, 'join'])->name('join');
                });

            Route::prefix('tasks')
                ->as('tasks.')
                ->group(function () {
                    Route::get('', action: [StudentTasksController::class, 'index'])->name('index');
                    Route::get('{id}', action: [StudentTasksController::class, 'show'])->name('show');
                    Route::post('{id}/submit', action: [StudentTasksController::class, 'submitTask'])->name('submit');
                });
        });
});

require __DIR__ . '/auth.php';
