<?php

namespace App\Http\Controllers\Teacher;

use App\Models\StudentTask;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentTaskController extends Controller
{
    public function show(string $id)
    {
        $studentTask = StudentTask::find($id);

        return view('users.teacher.classroom.task.student-task', compact(['studentTask']));
    }

    public function addScore(Request $request, string $id){
        $studentTask = StudentTask::find($id);


        if(!$request->score){
            return back()->with(['error' => 'score fields is Required']);
        }


        $studentTask->update([
            'score' => $request->score
        ]);


        return back()->with(['message' => 'Score added']);
    }

}
