<?php

namespace App\Http\Controllers\Student;

use App\Enums\GeneralStatus;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AttachmentStudent;
use App\Models\StudentTask;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function  index(string $id)
    {

        $user = Auth::user();

        return Task::where(function ($q) use ($id, $user) {
            $q->where('classroom_id', $id)
                ->whereHas('assignStudents', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
        })->with(['attachments', 'assignStudents' => function ($q) use ($user) {
            $q->where('user_id', $user->id);
        }])->withCount([
            'attachments'
        ])->latest()->get();
    }
    public function show(string $id)
    {
        $user = Auth::user();

        return StudentTask::where(function ($q) use ($id, $user) {
            $q->whereHas('task', function ($q) use ($id) {
                $q->where('id', $id);
            })
                ->where('user_id', $user->id);
        })->with([
            'task.attachments'
        ])->latest()->first();
    }
    public function submitTask(Request $request, string $id)
    {

        $studentTask = StudentTask::find($id);



        if ($request->hasFile('attachments')) {
            $attachments = $request->file('attachments');



            foreach ($attachments as $attachment) {



                $fileContent = file_get_contents($attachment->getPathname());


                $extension = $attachment->getClientOriginalExtension();
                $fileName = "{$studentTask->task->name}-" . uniqid() . '.' . $extension;
                $type = $attachment->getMimeType();



                $storagePath = "public/students/attachment/" . $fileName;




                if (!Storage::put($storagePath, $fileContent)) {
                    throw new \Exception('Failed to save the file');
                }


                AttachmentStudent::create([
                    'file_dir' => asset('/storage/students/attachment/' . $fileName),
                    'type' => $type,
                    'extension' => $extension,
                    'student_task_id' => $studentTask->id,
                ]);



            }
        }

        // Update the student task status to submitted
        $studentTask->update([
            'status' => GeneralStatus::SUBMITTED->value,
        ]);

        return response(['message' => 'Task Submitted']);
    }
}
