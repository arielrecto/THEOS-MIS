<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CSVTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $headers = [
            'email',
            'password',
            'lrn',
            'last_name',
            'first_name',
            'middle_name',
            'extension_name',
            'birthdate',
            'birthplace',
            'house_no',
            'street',
            'barangay',
            'city',
            'province',
            'zip_code',
            'perm_house_no',
            'perm_street',
            'perm_barangay',
            'perm_city',
            'perm_province',
            'perm_zip_code',
            'parent_name',
            'relationship',
            'contact_number',
            'occupation',
            'preferred_track',
            'preferred_strand',
            'modality',
            'school_year', // Added school_year
            'grade_level',
            'type',
            'balik_aral',
            'mother_name',
            'mother_last_name',
            'mother_middle_name',
            'mother_relationship',
            'mother_contact_number',
            'mother_occupation',
            'guardian_name',
            'guardian_last_name',
            'guardian_middle_name',
            'guardian_relationship',
            'guardian_contact_number',
            'guardian_occupation'
        ];

        $sampleData = [
            'student@example.com',
            'password123',
            '123456789012',
            'Dela Cruz',
            'Juan',
            'Pedro',
            'Jr.',
            '2005-01-15',
            'Manila',
            '123',
            'Rizal Street',
            'Poblacion',
            'Manila',
            'Metro Manila',
            '1000',
            '123',
            'Rizal Street',
            'Poblacion',
            'Manila',
            'Metro Manila',
            '1000',
            'Jose Dela Cruz',
            'Father',
            '09123456789',
            'Engineer',
            'ACADEMIC',
            'STEM',
            'Face-to-Face',
            '2024-2025', // Added school_year value
            'Grade 11',
            'new',
            'No',
            'Maria',
            'Santos',
            'Garcia',
            'Mother',
            '09123456780',
            'Teacher',
            'Roberto',
            'Reyes',
            'Cruz',
            'Uncle',
            '09123456781',
            'Business Owner'
        ];

        // Create CSV content
        $csv = implode(',', $headers) . "\n" . implode(',', $sampleData);

        // Ensure the directory exists
        if (!Storage::disk('public')->exists('templates')) {
            Storage::disk('public')->makeDirectory('templates');
        }

        // Save the CSV file
        Storage::disk('public')->put('templates/student_bulk_import_template.csv', $csv);
    }
}
