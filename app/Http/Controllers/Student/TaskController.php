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
    public function index(string $id = null)
    {
        $user = Auth::user();
        $query = Task::query();

        if ($id) {
            $query->where('classroom_id', $id);
        }

        $tasks = $query->whereHas('assignStudents', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
        ->with(['attachments', 'classroom', 'assignStudents' => function ($q) use ($user) {
            $q->where('user_id', $user->id);
        }])
        ->withCount('attachments')
        ->latest()
        ->get();

        return view('users.student.tasks.index', compact('tasks'));
    }

    public function show(string $id)
    {
        $user = Auth::user();
        $studentTask = StudentTask::where('user_id', $user->id)
            ->whereHas('task', function ($q) use ($id) {
                $q->where('id', $id);
            })
            ->with([
                'task.attachments',
                'task.classroom',
                'attachments'
            ])
            ->firstOrFail();

        return view('users.student.tasks.show', compact('studentTask'));
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
            'status' => 'submitted'
        ]);

        return redirect()
            ->route('student.tasks.show', $id)
            ->with('success', 'Task submitted successfully');
    }

    public function unsubmitTask(string $id)
    {
        $studentTask = StudentTask::find($id);

        $studentTask->update([
            'status' => 'unsubmitted'
        ]);

        return redirect()
            ->route('student.tasks.show', $id)
            ->with('success', 'Task unsubmitted successfully');
    }
}
