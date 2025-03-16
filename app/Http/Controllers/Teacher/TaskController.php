<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Task;
use App\Models\Classroom;
use App\Models\StudentTask;
use Illuminate\Http\Request;
use App\Models\AttachmentTask;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\TaskNotification;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $classroom_id = $request->classroom_id;

        $tasks = Task::latest()->paginate(10);


        if (!$classroom_id) {
            $tasks = Task::where('classroom_id', $classroom_id)->latest()->paginate(10);
        }


        return view('users.teacher.classroom.task.index', compact(['tasks', 'classroom_id']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $classroom_id = $request->classroom_id;

        $classroom = Classroom::find($classroom_id);

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

        ]);

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

            $message = [
                'header' => "Task {$task->name}",
                'message' => "Duration : {$task->start_date} - {$task->end_date}"
            ];

            $user->notify(new TaskNotification($message));
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


        return back()->with(['message' => 'Task Created Success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::whereId($id)->with([
            'attachments'
        ])->first();


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
        $task = Task::find($id);


        $task->delete();

        return back()->with(['message' => 'task Deleted Success']);
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

        // Validate the file object
        // Generate a unique name for the file
        $fileName = "{$name}-" . uniqid() . '.' . $extension;
        $filename = preg_replace('~[\\\\\s+/:*?"<>|+-]~', '-', $fileName);

        // Decode the base64 string
        $fileDecoded = base64_decode($base64);

        // Check if the decoding was successful
        if ($fileDecoded === false) {
            throw new \Exception('Base64 decode failed');
        }

        // Save the file to the specified path
        $storagePath = storage_path('app/public/' . $path . $filename);
        if (!file_put_contents($storagePath, $fileDecoded)) {
            throw new \Exception('Failed to save the file');
        }

        // Log successful file save
        Log::info('File saved successfully: ' . $filename);

        return $filename;
    }
}
