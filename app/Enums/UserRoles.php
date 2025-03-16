<?php


namespace App\Enums;



enum UserRoles :string{
    case ADMIN = 'admin';
    case TEACHER = 'teacher';
    case STUDENT = 'student';
    case REGISTRAR = 'registrar';
}
