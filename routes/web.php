<?php

use App\Models\StudentTask;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CMSController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HR\LeaveController;
use App\Http\Controllers\HR\ReportController;
use App\Http\Controllers\Admin\LogoController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\InboxController;
use App\Http\Controllers\HR\EmployeeController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Admin\StrandController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Teacher\TaskController;
use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\HR\DepartmentController;
use App\Http\Controllers\Teacher\GradeController;
use App\Http\Controllers\HR\JobPositionController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Teacher\ClassroomController;
use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Teacher\AttendanceController;
use App\Http\Controllers\Teacher\StudentTaskController;
use App\Http\Controllers\Registrar\EnrollmentController;
use App\Http\Controllers\Teacher\AnnouncementController;
use App\Http\Controllers\Admin\AcademicProgramController;
use App\Http\Controllers\Admin\GeneralAnnouncementController;
use App\Http\Controllers\Auth\TwoFactorAuthenticationController;
use App\Http\Controllers\HR\DashboardController as HRDashboardController;
use App\Http\Controllers\Student\TaskController as StudentTasksController;
use App\Http\Controllers\HR\AttendanceController as HRAttendanceController;
use App\Http\Controllers\Employee\LeaveController as EmployeeLeaveController;
use App\Http\Controllers\Registrar\GradeController as RegistrarGradeController;
use App\Http\Controllers\Teacher\ProfileController as TeacherProfileController;
use App\Http\Controllers\Teacher\StudentController as TeacherStudentController;
use App\Http\Controllers\EnrollmentController as ControllersEnrollmentController;
use App\Http\Controllers\Student\SettingsController as StudentSettingsController;
use App\Http\Controllers\Registrar\StudentController as RegistrarStudentController;
use App\Http\Controllers\Student\ClassroomController as StudentClassroomController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Employee\DashboardController as EmployeeDashboardController;
use App\Http\Controllers\Student\AttendanceController as StudentAttendanceController;
use App\Http\Controllers\Employee\AttendanceController as EmployeeAttendanceController;
use App\Http\Controllers\Registrar\DashboardController as RegistrarDashboardController;
use App\Http\Controllers\Student\AnnouncementController as StudentAnnouncementController;

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
Route::post('/contact-us', [InboxController::class, 'store'])->name('contact.submit');
Route::get('/gallery', [LandingPageController::class, 'gallery'])->name('gallery');
Route::get('/about-us', [LandingPageController::class, 'about'])->name('about');
Route::get('job-opportunities', [LandingPageController::class, 'jobOpportunities'])->name('job-opportunities');
Route::get('/job-opportunities/{position}', [LandingPageController::class, 'showJob'])->name('job-opportunities.show');
Route::post('/job-opportunities/{position}/apply', [LandingPageController::class, 'applyJob'])->name('job-opportunities.apply');
Route::get('general-announcements/{id}', [LandingPageController::class, 'generalAnnouncementShow'])->name('general-announcements.show');
Route::get('/home', [HomeController::class, 'index'])
    ->name('home')
    ->middleware(['auth']);

Route::prefix('enrollment')
    ->as('enrollment.')
    ->group(function () {
        Route::get('/form', [ControllersEnrollmentController::class, 'form'])->name('form');
        Route::get('/{enrollemntForm}/application-message', [ControllersEnrollmentController::class, 'applicationMessage'])->name('applicationMessage');
        Route::get('/{id}', [ControllersEnrollmentController::class, 'show'])->name('show');
        Route::get('/{id}/print', [ControllersEnrollmentController::class, 'print'])->name('print');
        Route::post('/', [ControllersEnrollmentController::class, 'store'])->name('store');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/two-factor', [ProfileController::class, 'twoFactor'])->name('profile.two-factor');
});

Route::middleware(['auth'])->group(function () {

    Route::prefix('notifications')->as('notifications.')->group(function () {

        Route::post('mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::get('', [NotificationController::class, 'index'])->name('index');
        Route::post('clear-all', [NotificationController::class, 'clearAll'])->name('clear-all');
        Route::delete('{notification}', [NotificationController::class, 'destroy'])->name('destroy');
        Route::get('{notification}', [NotificationController::class, 'show'])->name('show');
        Route::post('{notification}', [NotificationController::class, 'markAsRead'])->name('mark-as-read');
    });


    Route::prefix('two-factor-authentication')->as('two-factor-authentication.')->group(function () {
        Route::get('show', [TwoFactorAuthenticationController::class, 'show'])->name('show');
        Route::post('verify', [TwoFactorAuthenticationController::class, 'verify'])->name('verify');
        Route::post('resend', [TwoFactorAuthenticationController::class, 'resend'])->name('resend');
    });

    Route::middleware(['role:admin', 'two_factor_authentication'])
        ->prefix('admin')
        ->as('admin.')
        ->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
            Route::prefix('users')
                ->as('users.')
                ->group(function () {
                    Route::get('', [UserController::class, 'index'])->name('index');
                    Route::prefix('students')->as('students.')->group(function () {
                        Route::put('update-profile/{id}', [StudentController::class, 'updateProfile'])->name('update-profile');
                        Route::put('update-email/{id}', [StudentController::class, 'updateEmail'])->name('update-email');
                        Route::put('update-password/{id}', [StudentController::class, 'updatePassword'])->name('update-password');
                    });
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

            Route::prefix('CMS')->as('CMS.')->group(function () {
                Route::get('', [CMSController::class, 'index'])->name('index');
                Route::prefix('logos')->as('logos.')->group(function () {
                    Route::get('', [LogoController::class, 'index'])->name('index');
                    Route::post('', [LogoController::class, 'store'])->name('store');
                    Route::put('{logo}/toggle', [LogoController::class, 'toggleActive'])->name('toggle');
                    Route::delete('{logo}', [LogoController::class, 'destroy'])->name('destroy');
                });


                Route::prefix('gallery')->as('gallery.')->group(function () {
                    Route::put('{gallery}/toggle', [GalleryController::class, 'toggleActive'])->name('toggle');
                });

                Route::prefix('about-us')->as('about-us.')->group(function () {
                    Route::get('', [AboutUsController::class, 'index'])->name('index');
                    Route::put('about-us', [AboutUsController::class, 'update'])->name('update');
                });


                Route::prefix('programs')->as('programs.')->group(function () {
                    Route::put('{program}/toggle', [AcademicProgramController::class, 'toggleActive'])->name('toggle');
                });


                Route::prefix('contact')->as('contact.')->group(function () {
                    Route::get('', [ContactUsController::class, 'index'])->name('index');
                    Route::post('', [ContactUsController::class, 'store'])->name('store');
                });



                Route::resource('programs', AcademicProgramController::class);

                Route::resource('gallery', GalleryController::class);
            });


            Route::prefix('inbox')->group(function () {
                Route::post('{inbox}/read', [InboxController::class, 'markAsRead'])->name('admin.inbox.read');
            });

            Route::resource('inbox', InboxController::class)->except('store');
        });

    Route::middleware(['role:teacher', 'two_factor_authentication'])
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
                        Route::prefix('comments')->as('comments.')->group(function () {
                            Route::post('', [TaskController::class, 'comment'])->name('store');
                            Route::delete('{comment}', [TaskController::class, 'commentDelete'])->name('delete');
                            Route::post('{id}/replies', [TaskController::class, 'commentReply'])->name('reply');
                        });
                    });

                Route::prefix('announcements')
                    ->as('announcements.')
                    ->group(function () {
                        Route::get('remove-file', [AnnouncementController::class, 'removeFile'])->name('remove-file');
                        Route::post('{announcement}/comments', [AnnouncementController::class, 'storeComment'])->name('comments.store');
                        Route::delete('comments/{comment}', [AnnouncementController::class, 'destroyComment'])->name('comments.destroy');
                        Route::post('comments/{comment}/replies', [AnnouncementController::class, 'replyComment'])->name('comments.reply');
                    });

                Route::resource('classrooms', ClassroomController::class);
                Route::resource('announcements', AnnouncementController::class);
                Route::resource('tasks', TaskController::class);
            });



            Route::resource('profile', TeacherProfileController::class)->except('index');
        });

    Route::middleware(['role:registrar', 'two_factor_authentication'])
        ->prefix('registrar')
        ->as('registrar.')
        ->group(function () {
            Route::get('/dashboard', [RegistrarDashboardController::class, 'dashboard'])->name('dashboard');
            Route::prefix('enrollments')
                ->as('enrollments.')
                ->group(function () {
                    Route::get('/form/{id}', [EnrollmentController::class, 'showEnrollee'])->name('showEnrollee');
                    Route::put('/form/{id}', [EnrollmentController::class, 'enrolled'])->name('enrolled');
                    Route::patch('{enrollment}/close', [EnrollmentController::class, 'close'])->name('close');
                    Route::get('/print/{id}', [EnrollmentController::class, 'print'])->name('print');
                });

            Route::prefix('students')
                ->as('students.')
                ->group(function () {
                    Route::get('', [RegistrarStudentController::class, 'index'])->name('index');
                    Route::get('{student}', [RegistrarStudentController::class, 'show'])->name('show');
                    Route::get('{student}/records/{record}/print', [RegistrarStudentController::class, 'print'])->name('print');
                    Route::get('{student}/good-moral', [RegistrarStudentController::class, 'printGoodMoral'])->name('good-moral');
                    Route::get('{student}/form-137', [RegistrarStudentController::class, 'printForm137'])->name('form-137');
                });

            Route::prefix('grades')
                ->as('grades.')
                ->group(function () {
                    Route::get('', [RegistrarGradeController::class, 'index'])->name('index');
                    Route::get('{student}', [RegistrarGradeController::class, 'show'])->name('show');
                });
            Route::resource('enrollments', EnrollmentController::class);
        });

    Route::middleware(['role:student', 'two_factor_authentication'])
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
                    Route::post('{id}/unsubmit', action: [StudentTasksController::class, 'unsubmitTask'])->name('unsubmit');
                    Route::prefix('comments')->as('comments.')->group(function () {
                        Route::post('', action: [StudentTasksController::class, 'comment'])->name('store');
                        Route::delete('{comment}', action: [StudentTasksController::class, 'commentDelete'])->name('delete');
                        Route::post('{id}/replies', action: [StudentTasksController::class, 'commentReply'])->name('reply');
                    });
                });

            Route::prefix('settings')
                ->as('settings.')
                ->group(function () {
                    Route::get('', [StudentSettingsController::class, 'index'])->name('index');
                    Route::patch('/profile', [StudentSettingsController::class, 'updateProfile'])->name('profile.update');
                    Route::patch('/email', [StudentSettingsController::class, 'updateEmail'])->name(name: 'email.update');
                    Route::patch('/password', [StudentSettingsController::class, 'updatePassword'])->name('password.update');
                });

            Route::prefix('announcements')
                ->as('announcements.')
                ->group(function () {
                    Route::post('{announcement}/comments', [StudentAnnouncementController::class, 'storeComment'])->name('comments.store');
                    Route::delete('comments/{comment}', [StudentAnnouncementController::class, 'destroyComment'])->name('comments.destroy');
                    Route::post('comments/{comment}/replies', [StudentAnnouncementController::class, 'replyComment'])->name('comments.reply');
                });

            Route::prefix('attendances')->as('attendances.')->group(function () {
                Route::post('/log', [StudentAttendanceController::class, 'log'])->name('log');
                Route::get('', [StudentAttendanceController::class, 'index'])->name('index');
                Route::get('/scanner', [StudentAttendanceController::class, 'scanner'])->name('scanner');
            });
        });
    Route::middleware(['role:human-resource|admin', 'two_factor_authentication'])
        ->prefix('hr')
        ->as('hr.')
        ->group(function () {
            Route::get('/dashboard', action: [HRDashboardController::class, 'dashboard'])->name('dashboard');
            Route::prefix('departments')->as('departments.')->group(function () {
                Route::post('{department}/toggle-status', [DepartmentController::class, 'toggleStatus'])->name('toggle-status');
            });
            Route::resource('departments', DepartmentController::class);
            Route::prefix('positions')->as('positions.')->group(function () {
                Route::post('{id}/toggle-hiring', [JobPositionController::class, 'toggleHiring'])->name('toggle-hiring');
            });
            Route::resource('positions', JobPositionController::class);
            Route::get('applicants', [JobPositionController::class, 'applicants'])->name('applicants.index');
            Route::get('applicants/{applicant}', [JobPositionController::class, 'showApplicant'])->name('applicants.show');
            Route::put('applicants/{applicant}/status', [JobPositionController::class, 'updateApplicantStatus'])->name('applicants.update-status');

            Route::prefix('employees')->as('employees.')->group(function () {
                Route::get('', [EmployeeController::class, 'index'])->name('index');
                Route::get('create', [EmployeeController::class, 'create'])->name('create');
                Route::post('', [EmployeeController::class, 'store'])->name('store');
                Route::get('{employee}', [EmployeeController::class, 'show'])->name('show');
                Route::get('{employee}/edit', [EmployeeController::class, 'edit'])->name('edit');
                Route::get('{id}/print', [EmployeeController::class, 'print'])->name('print');
                Route::put('{employee}', [EmployeeController::class, 'update'])->name('update');
                Route::delete('{employee}', [EmployeeController::class, 'destroy'])->name('destroy');
                Route::patch('{employee}/toggle-teacher', [EmployeeController::class, 'toggleTeacher'])->name('toggle-teacher');
                Route::patch('{employee}/toggle-registrar', [EmployeeController::class, 'toggleRegistrar'])->name('toggle-registrar');
            });

            Route::prefix('attendance')->as('attendance.')->group(function () {
                Route::get('', [HRAttendanceController::class, 'index'])->name('index');
                Route::get('{employee}', [HRAttendanceController::class, 'show'])->name('show');
                Route::post('{employee}/log', [HRAttendanceController::class, 'log'])->name('log');
                Route::get('{employee}/print', [HRAttendanceController::class, 'print'])->name('print');
            });

            Route::prefix('leaves')->as('leaves.')->group(function () {
                Route::get('', [LeaveController::class, 'index'])->name('index');
                Route::put('{leave}/approve', [LeaveController::class, 'approve'])->name('approve');
                Route::put('{leave}/reject', [LeaveController::class, 'reject'])->name('reject');
            });

            Route::prefix('reports')->as('reports.')->group(function () {
                Route::get('', [ReportController::class, 'index'])->name('index');
                Route::get('attendance', [ReportController::class, 'attendance'])->name('attendance');
                Route::get('leave', [ReportController::class, 'leave'])->name('leave');
                Route::get('recruitment', [ReportController::class, 'recruitment'])->name('recruitment');
            });
        });

    Route::middleware(['role:employee', 'two_factor_authentication'])->as('employee.')->group(function () {
        Route::get('/dashboard', [EmployeeDashboardController::class, 'dashboard'])->name('dashboard');

        Route::prefix('attendance')->as('attendance.')->group(function () {
            Route::get('', [EmployeeAttendanceController::class, 'index'])->name('index');
            Route::post('check-in', [EmployeeAttendanceController::class, 'checkIn'])->name('check-in');
            Route::post('check-out', [EmployeeAttendanceController::class, 'checkOut'])->name('check-out');
            Route::get('print', [EmployeeAttendanceController::class, 'printAttendance'])->name('print');
        });

        Route::prefix('leaves')->as('leaves.')->group(function () {
            Route::get('', [EmployeeLeaveController::class, 'index'])->name('index');
            Route::post('', [EmployeeLeaveController::class, 'store'])->name('store');
        });
    });
});

require __DIR__ . '/auth.php';
