<?php


namespace App\Enums;



enum UserRoles :string{
    case ADMIN = 'admin';
    case TEACHER = 'teacher';
    case STUDENT = 'student';
    case REGISTRAR = 'registrar';
    case HUMAN_RESOURCE = 'human-resource';

    case EMPLOYEE = 'employee';
}
