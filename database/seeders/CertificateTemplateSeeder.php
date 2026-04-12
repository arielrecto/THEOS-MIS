<?php

namespace Database\Seeders;

use App\Models\CertificateTemplate;
use Illuminate\Database\Seeder;

class CertificateTemplateSeeder extends Seeder
{
    public function run()
    {
        // Good Moral Certificate
        CertificateTemplate::create([
            'name' => 'Good Moral Certificate',
            'type' => 'good_moral',
            'title' => 'Certificate of Good Moral Character',
            'content' => 'This is to certify that <strong>{{student_name}}</strong>, with LRN: <strong>{{lrn}}</strong> was a bonafide student of THEOS HIGHER GROUND ACADEME INC., school year <strong>{{academic_year}}</strong>. This further certifies that he/she is a law abiding pupil with good moral character and has been seen as record of misconduct.

This certification is issued for whatever legal purposes it may serve him/her.

Given on this {{current_date}} at Theos Higher Ground Academe.',
            'footer' => 'Not valid without school seal',
            'signatory_name' => 'Ms. Esther Fe O. Rendal, LPT, MAED',
            'signatory_title' => 'School Principal',
            'is_active' => true,
        ]);

        // Form 137 Template
        CertificateTemplate::create([
            'name' => 'Form 137 - Permanent Academic Record',
            'type' => 'form_137',
            'title' => 'PERMANENT ACADEMIC RECORD',
            'content' => 'I hereby certify that this is a true and accurate record of <strong>{{student_name}}</strong>.',
            'footer' => 'Not valid without school seal',
            'signatory_name' => 'Jun Rendal',
            'signatory_title' => 'School Head',
            'is_active' => true,
        ]);
    }
}
