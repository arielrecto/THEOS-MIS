<?php

namespace App\Enums;



enum GeneralStatus: string
{

    case PRESENT = 'present';
    case ABSENT = 'absent';
    case ONGOING = 'on going';
    case NOTASSIGN = 'not assigned';
    case ASSIGN = 'assigned';
    case SUBMITTED = 'submitted';
    case GRADED =  'graded';
    case MISSING = 'Missing';
    case NOTGRADED = 'not graded';
    case COMPLETED = 'completed';
    case PENDING = 'pending';
    case ENROLLED = 'enrolled';
}
