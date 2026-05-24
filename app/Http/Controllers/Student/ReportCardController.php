<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AcademicRecord;
use App\Models\AttendanceStudent;
use App\Models\LearnerObservedValue;
use Illuminate\Http\Request;

class ReportCardController extends Controller
{
    public function index(Request $request)
    {
        $student = auth()->user()->load([
            'studentProfile.academicRecords.academicYear',
        ]);

        $academicRecords = $student->studentProfile?->academicRecords ?? collect();

        $selectedRecord = null;
        $daysOfSchool = [];
        $daysPresent = [];
        $totalSchool = 0;
        $totalPresent = 0;
        $coreValues = [];
        $coreValueRecords = [];

        $academicRecordId = $request->get('academic_record_id', $academicRecords->first()?->id);

        if ($academicRecordId) {
            $selectedRecord = AcademicRecord::with([
                'academicYear',
                'section',
                'grades' => function ($query) {
                    $query->orderBy('subject')->orderBy('quarter');
                }
            ])->where('id', $academicRecordId)
              ->where('student_profile_id', $student->studentProfile?->id)
              ->firstOrFail();

            $months = ['Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May'];

            $attendance = AttendanceStudent::where('user_id', $student->id)
                ->where('academic_year_id', $selectedRecord->academic_year_id)
                ->whereIn('month', $months)
                ->get()
                ->keyBy('month');

            foreach ($months as $month) {
                $record = $attendance->get($month);
                $school = $record->days_of_school ?? '-';
                $present = $record->days_present ?? '-';
                $daysOfSchool[] = $school;
                $daysPresent[] = $present;
                $totalSchool += is_numeric($school) ? $school : 0;
                $totalPresent += is_numeric($present) ? $present : 0;
            }

            $coreValues = [
                'Makadiyos' => [
                    "Express one's spiritual beliefs while respecting the spiritual beliefs of others",
                    'Show adherence to ethical principles by upholding truth',
                ],
                'Makatao' => [
                    'Is sensitive to individual, social, cultural differences',
                    'Demonstrate contributions toward solidarity',
                ],
                'Makakalikasan' => [
                    'Cares for the environment and utilizes resources wisely, judiciously, and economically',
                ],
                'Makabansa' => [
                    'Demonstrates pride in being a Filipino, exercises the rights and responsibilities of a Filipino citizen',
                    'Demonstrates appropriate behavior in carrying out activities in the school, community and country',
                ],
            ];

            $studentIds = array_unique([$student->id, $student->studentProfile?->id]);
            $records = LearnerObservedValue::where('academic_year_id', $selectedRecord->academic_year_id)
                ->whereIn('student_id', array_filter($studentIds))
                ->get();

            foreach ($records as $rec) {
                $coreValueRecords[$rec->core_value][$rec->behavior_statement] = $rec;
            }
        }

        return view('users.student.report-card.index', compact(
            'student',
            'academicRecords',
            'selectedRecord',
            'daysOfSchool',
            'daysPresent',
            'totalSchool',
            'totalPresent',
            'coreValues',
            'coreValueRecords'
        ));
    }

    public function print(AcademicRecord $academicRecord)
    {
        $student = auth()->user()->load('studentProfile');

        abort_if(
            $academicRecord->student_profile_id !== $student->studentProfile?->id,
            403
        );

        $academicRecord->load([
            'academicYear',
            'section',
            'grades' => fn($q) => $q->orderBy('subject')->orderBy('quarter'),
        ]);

        $months = ['Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May'];

        $attendance = AttendanceStudent::where('user_id', $student->id)
            ->where('academic_year_id', $academicRecord->academic_year_id)
            ->whereIn('month', $months)
            ->get()
            ->keyBy('month');

        $daysOfSchool = [];
        $daysPresent = [];
        $totalSchool = 0;
        $totalPresent = 0;

        foreach ($months as $month) {
            $rec = $attendance->get($month);
            $school = $rec->days_of_school ?? '-';
            $present = $rec->days_present ?? '-';
            $daysOfSchool[] = $school;
            $daysPresent[] = $present;
            $totalSchool += is_numeric($school) ? $school : 0;
            $totalPresent += is_numeric($present) ? $present : 0;
        }

        $coreValues = [
            'Makadiyos' => [
                "Express one's spiritual beliefs while respecting the spiritual beliefs of others",
                'Show adherence to ethical principles by upholding truth',
            ],
            'Makatao' => [
                'Is sensitive to individual, social, cultural differences',
                'Demonstrate contributions toward solidarity',
            ],
            'Makakalikasan' => [
                'Cares for the environment and utilizes resources wisely, judiciously, and economically',
            ],
            'Makabansa' => [
                'Demonstrates pride in being a Filipino, exercises the rights and responsibilities of a Filipino citizen',
                'Demonstrates appropriate behavior in carrying out activities in the school, community and country',
            ],
        ];

        $studentIds = array_unique([$student->id, $student->studentProfile?->id]);
        $records = LearnerObservedValue::where('academic_year_id', $academicRecord->academic_year_id)
            ->whereIn('student_id', array_filter($studentIds))
            ->get();

        $coreValueRecords = [];
        foreach ($records as $rec) {
            $coreValueRecords[$rec->core_value][$rec->behavior_statement] = $rec;
        }

        return view('users.student.report-card.print', compact(
            'student',
            'academicRecord',
            'daysOfSchool',
            'daysPresent',
            'totalSchool',
            'totalPresent',
            'coreValues',
            'coreValueRecords'
        ));
    }
}
