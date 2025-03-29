<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Strand;
use App\Models\Subject;
use App\Enums\UserRoles;
use App\Models\Department;
use App\Models\Enrollment;
use App\Models\AcademicYear;
use App\Enums\EnrollmentStatus;
use Illuminate\Database\Seeder;
use App\Enums\AcademicYearStatus;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        $roles = UserRoles::cases();


        collect($roles)->map(function ($role) {
            Role::create([
                'name' => $role->value
            ]);
        });


        $adminRole = Role::where('name', UserRoles::ADMIN->value)->first();

        $teacherRole = Role::where('name', UserRoles::TEACHER->value)->first();

        $registrarRole = Role::where('name', UserRoles::REGISTRAR->value)->first();

        $hrRole = Role::where('name', UserRoles::HUMAN_RESOURCE->value)->first();

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123')
        ]);

        $teacher = User::create([
            'name' => 'teacher',
            'email' => 'teacher@teacher.com',
            'password' => Hash::make('teacher123')
        ]);


        $registrar = User::create([
            'name' => 'registrar',
            'email' => 'registrar@registrar.com',
            'password' => Hash::make('registrar123')
        ]);


        $hr = User::create([
            'name' => 'HR',
            'email' => 'hr@hr.com',
            'password' => Hash::make('hr123')
        ]);


        Strand::create([
            'name' => 'INFORMATION AND COMMUNICATION TECHNOLOGY',
            'acronym' => 'ICT',
            'descriptions' => 'sample description'
        ]);

        $subjects = [
            [
                'name' => 'ORAL COMMUNICATION',
                'subject_code' => "ORL-101",
                'description' => 'SAMPLE DESCRIPTION'
            ],
            [
                'name' => 'ENGLISH LANGUAGE',
                'subject_code' => "ENL-101",
                'description' => 'SAMPLE DESCRIPTION'
            ],
            [
                'name' => 'MATHEMATICS',
                'subject_code' => "MTH-101",
                'description' => 'SAMPLE DESCRIPTION'
            ]
        ];



        collect($subjects)->map(function($subject){
            Subject::create([
                'name' => $subject['name'],
                'subject_code' => $subject['subject_code'],
                'description' => $subject['description']
            ]);
        });


        $academicYear = AcademicYear::create([
            'name' => '2025-2026',
            'start_date' => now(),
            'end_date' => now()->addYear(),
            'status' => AcademicYearStatus::Active->value
        ]);


        $enrollment = Enrollment::create([
            'academic_year_id' => $academicYear->id,
            'name' => '2025-2026',
            'start_date' => now(),
            'end_date' => now()->addYear(),
            'status' => EnrollmentStatus::ONGOING->value
        ]);


        $admin->assignRole($adminRole);

        $teacher->assignRole($teacherRole);
        $registrar->assignRole($registrarRole);


        $hr->assignRole($hrRole);



        $departments = [
            'HR',
            'Education',
            'Maintenance',
            'Admissions',
        ];


        collect($departments)->map(function ($department) {
            Department::create([
                'name' => $department,
                'description' => 'sample description'
            ]);
        });
    }
}
