<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Task;
use App\Models\User;
use App\Models\Comment;
use App\Models\Classroom;
use App\Models\StudentTask;
use Illuminate\Http\Request;
use App\Models\AttachmentTask;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TaskNotification;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // The teacher's active classrooms drive the subject tabs and scope every query,
        // so a teacher only ever sees tasks from their own classrooms.
        $classrooms = $this->ownedClassrooms()
            ->where('is_archived', false)
            ->with(['subject', 'strand'])
            ->latest()
            ->get();

        $classroom_id = $request->classroom_id;
        $classroom = null;

        if ($classroom_id) {
            // Archived classrooms are still reachable directly, just not listed as tabs.
            $classroom = $this->ownedClassrooms()
                ->with('subject')
                ->findOrFail($classroom_id);
        }

        $tasks = Task::whereIn('classroom_id', $classroom ? [$classroom->id] : $classrooms->pluck('id'))
            ->with('classroom.subject')
            ->withCount([
                'assignStudents',
                'assignStudents as submitted_count' => fn($query) => $query->where('status', 'submitted'),
            ])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('users.teacher.classroom.task.index', compact(['tasks', 'classroom_id', 'classroom', 'classrooms']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $classroom_id = $request->classroom_id;

        // A task always belongs to a classroom, so the teacher must pick a subject first.
        if (!$classroom_id) {
            return redirect()->route('teacher.tasks.index')
                ->with('warning', 'Select a subject first, then click Create to add a task to it.');
        }

        $classroom = $this->ownedClassrooms()->findOrFail($classroom_id);

        $students =  json_encode($classroom->classroomStudents()->with(['student'])->get());

        return view('users.teacher.classroom.task.create', compact(['students', 'classroom_id']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $request->validate([
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'description' => 'required',
            'classroom_id' => 'required',
        ]);

        $this->ownedClassrooms()->findOrFail($request->classroom_id);

        $attachments = json_decode($request->attachments);

        $task = Task::create([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'max_score' => $request->max_score ?? 100,
            'description' => $request->description,
            'score' => 0,
            'classroom_id' => $request->classroom_id
        ]);

        $c_students = json_decode($request->students);

        collect($c_students)->map(function ($c_student) use ($task) {
            $studentId =  $c_student->student->id;
            StudentTask::create([
                'user_id' => $studentId,
                'task_id' => $task->id
            ]);

            $user = User::find($studentId);

            $task->load('classroom.subject');
            $user->notify(new TaskNotification($task, $user));
        });

        if (count($attachments) !== 0) {

            collect($attachments)->map(function ($attachment) use ($task) {
                if ($attachment->type === 'url') {
                    AttachmentTask::create([
                        'file' => $attachment->data,
                        'type' => $attachment->type,
                        'extension' => 'url',
                        'task_id' => $task->id
                    ]);
                    return;
                }

                $fileDir = $this->handleFileObject($attachment, 'attachments/', 'FILE');

                AttachmentTask::create([
                    'file' => asset('/storage/attachments/' . $fileDir),
                    'type' => $attachment->type,
                    'extension' => $attachment->extension,
                    'task_id' => $task->id
                ]);
            });
        }


        return back()->with(['success' => 'Task Created Success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = $this->ownedTasks()->with([
            'attachments'
        ])->findOrFail($id);


        return view('users.teacher.classroom.task.show', compact(['task']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = $this->ownedTasks()->findOrFail($id);

        $task->delete();

        return back()->with(['message' => 'task Deleted Success']);
    }

    public function comment(Request $request){
        $studentTask = StudentTask::find($request->student_task_id);


       

        Comment::create([
            'content' => $request->content, 
            'user_id' => Auth::user()->id, 
            'commentable_id' => $studentTask->id, 
            'commentable_type' => get_class($studentTask)
        ]);

        return back()
            ->with('success', 'Comment added successfully');
    }


    public function commentDelete(string $id){
        $comment = Comment::find($id);

        $comment->delete();

        return back()
            ->with('success', 'Comment deleted successfully');
    }


    public function commentReply (Request $request, $id){
        $comment = Comment::find($id);

        Comment::create([
            'content' => $request->content, 
            'user_id' => Auth::user()->id, 
            'commentable_id' => $comment->id, 
            'commentable_type' => get_class($comment)
        ]);

        return back()
            ->with('success', 'Comment added successfully');
    }


    /**
     * Classrooms owned by the authenticated teacher.
     */
    private function ownedClassrooms()
    {
        return Classroom::where('teacher_id', Auth::id());
    }

    /**
     * Tasks that belong to one of the authenticated teacher's classrooms.
     */
    private function ownedTasks()
    {
        return Task::whereHas('classroom', fn($query) => $query->where('teacher_id', Auth::id()));
    }

    private function handleFileObject($fileObject, string $path, string $name)
    {
        if (!isset($fileObject->data, $fileObject->extension)) {
            throw new \Exception('Invalid file object');
        }

        // Retrieve base64-encoded data and extension
        $base64 = $fileObject->data;
        list($type) = explode(';', $base64);
        $extension = strtolower($fileObject->extension);

        // Replace any spaces with plus signs (if necessary)
        $base64 = str_replace("{$type};base64,", '', $base64);
        $base64 = str_replace(' ', '+', $base64);

        // Generate a unique name for the file
        $fileName = "{$name}-" . uniqid() . '.' . $extension;
        $filename = preg_replace('~[\\\\\s+/:*?"<>|+-]~', '-', $fileName);

        // Decode the base64 string
        $fileDecoded = base64_decode($base64);

        // Check if the decoding was successful
        if ($fileDecoded === false) {
            throw new \Exception('Base64 decode failed');
        }

        // Create storage directory if it doesn't exist
        $storagePath = storage_path('app/public/' . $path);
        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0755, true);
        }

        // Save the file to the specified path
        $fullPath = $storagePath . $filename;
        if (!file_put_contents($fullPath, $fileDecoded)) {
            throw new \Exception('Failed to save the file');
        }

        // Log successful file save
        Log::info('File saved successfully: ' . $filename);

        return $filename;
    }
}
