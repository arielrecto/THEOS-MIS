<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateTemplate extends Model
{
    protected $fillable = [
        'name',
        'type',
        'title',
        'content',
        'footer',
        'signatory_name',
        'signatory_title',
        'signatory_name_2',
        'signatory_title_2',
        'signatory_name_3',
        'signatory_title_3',
        'header_text',
        'is_active'
    ];

    /**
     * Replace placeholders with actual student data
     */
    public function render($student)
    {
        $data = [
            '{{student_name}}' => strtoupper($student->name),
            '{{student_name_lower}}' => $student->name,
            '{{lrn}}' => $student->studentProfile?->lrn ?? 'N/A',
            '{{academic_year}}' => $student->studentProfile?->academicRecords->first()?->academicYear?->name ?? '________',
            '{{current_date}}' => now()->format('jS \d\a\y \o\f F Y'),
            '{{grade_level}}' => $student->studentProfile?->academicRecords->first()?->grade_level ?? 'N/A',
            '{{section}}' => $student->studentProfile?->academicRecords->first()?->section?->name ?? 'N/A',
            '{{birthdate}}' => $student->studentProfile?->birthdate ? \Carbon\Carbon::parse($student->studentProfile->birthdate)->format('F d, Y') : 'N/A',
            '{{address}}' => $student->studentProfile?->address ?? 'N/A',
            '{{parent_name}}' => $student->studentProfile?->parent_name ?? 'N/A',
            '{{contact_number}}' => $student->studentProfile?->contact_number ?? 'N/A',
        ];

        $rendered = str_replace(
            array_keys($data),
            array_values($data),
            $this->content
        );

        return $rendered;
    }

    /**
     * Get available placeholders
     */
    public static function getAvailablePlaceholders()
    {
        return [
            '{{student_name}}' => 'Student Name (UPPERCASE)',
            '{{student_name_lower}}' => 'Student Name (Normal Case)',
            '{{lrn}}' => 'Learner Reference Number',
            '{{academic_year}}' => 'Academic Year',
            '{{current_date}}' => 'Current Date',
            '{{grade_level}}' => 'Grade Level',
            '{{section}}' => 'Section Name',
            '{{birthdate}}' => 'Student Birth Date',
            '{{address}}' => 'Student Address',
            '{{parent_name}}' => 'Parent/Guardian Name',
            '{{contact_number}}' => 'Contact Number',
        ];
    }
}
