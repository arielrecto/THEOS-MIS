<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AcademicRecord;
use App\Models\AttendanceStudent;
use App\Models\LearnerObservedValue;
use App\Models\Payment;
use App\Models\PaymentAccount;
use App\Models\Strand;
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
        $isFullyPaid = false;
        $totalDue = 0;
        $totalPaid = 0;
        $totalPending = 0;
        $balance = 0;
        $tuitionFees = collect();
        $paymentAccounts = collect();

        $academicRecordId = $request->get('academic_record_id', $academicRecords->first()?->id);


        if ($academicRecordId) {
            $selectedRecord = AcademicRecord::with([
                'academicYear',
                'section.strand.tuitionFees' => fn($q) => $q->where('is_active', true),
                'grades' => fn($q) => $q->orderBy('subject')->orderBy('quarter'),
            ])->where('id', $academicRecordId)
              ->where('student_profile_id', $student->studentProfile?->id)
              ->firstOrFail();

            // --- Payment check ---
            $strand = Strand::where('name', $selectedRecord->grade_level)->first();
            $tuitionFees = $strand
                ? $strand->tuitionFees()->where('is_active', true)->get()
                : collect();


            $totalDue = (float) $tuitionFees->sum('amount');

            $totalPaid = (float) Payment::where('user_id', $student->id)
                ->where('status', 'approved')
                ->sum('amount');

            $totalPending = (float) Payment::where('user_id', $student->id)
                ->where('status', 'pending')
                ->sum('amount');

            $balance = max(0, $totalDue - $totalPaid);
            $isFullyPaid = $totalDue <= 0 || $totalPaid >= $totalDue;

            $paymentAccounts = PaymentAccount::all();

            // --- Attendance & core values (only needed if paid) ---
            if ($isFullyPaid) {
                $months = ['Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May'];

                $attendance = AttendanceStudent::where('user_id', $student->id)
                    ->where('academic_year_id', $selectedRecord->academic_year_id)
                    ->whereIn('month', $months)
                    ->get()
                    ->keyBy('month');

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
                $records = LearnerObservedValue::where('academic_year_id', $selectedRecord->academic_year_id)
                    ->whereIn('student_id', array_filter($studentIds))
                    ->get();

                foreach ($records as $rec) {
                    $coreValueRecords[$rec->core_value][$rec->behavior_statement] = $rec;
                }
            }
        }



        return view('users.student.report-card.index', compact(
            'student',
            'academicRecords',
            'selectedRecord',
            'isFullyPaid',
            'totalDue',
            'totalPaid',
            'totalPending',
            'balance',
            'tuitionFees',
            'paymentAccounts',
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
            'section.strand.tuitionFees' => fn($q) => $q->where('is_active', true),
            'grades' => fn($q) => $q->orderBy('subject')->orderBy('quarter'),
        ]);

        // Block print if not fully paid
        $strand = Strand::where('name', $academicRecord->grade_level)->first();
        $tuitionFees = $strand
            ? $strand->tuitionFees()->where('is_active', true)->get()
            : collect();
        $totalDue = (float) $tuitionFees->sum('amount');
        $totalPaid = (float) Payment::where('user_id', $student->id)
            ->where('status', 'approved')
            ->sum('amount');

        abort_if($totalDue > 0 && $totalPaid < $totalDue, 403, 'Report card is only available for fully paid students.');

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
