<?php

namespace App\Http\Controllers\HR;

use App\Models\User;
use App\Models\Profile;
use App\Models\Department;
use App\Models\JobPosition;
use App\Models\JobApplicant;
use Illuminate\Http\Request;
use App\Models\EmployeeProfile;
use App\Mail\EmployeeCredentials;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = EmployeeProfile::with([
            'user',
            'position',
            'position.department'
        ]);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->search}%")
                  ->orWhere('last_name', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('department')) {
            $query->whereHas('position.department', function($q) use ($request) {
                $q->where('id', $request->department);
            });
        }

        if ($request->filled('position')) {
            $query->where('job_position_id', $request->position);
        }

        $employees = $query->latest()->paginate(10);

        // Debug to verify relationships are loaded


        $departments = Department::all();
        $positions = JobPosition::all();

        return view('users.hr.employees.index', compact('employees', 'departments', 'positions'));
    }

    public function create(Request $request)
    {
        $applicant = null;
        if ($request->filled('applicant')) {
            $applicant = JobApplicant::with('position.department')->findOrFail($request->applicant);
        }

        $positions = JobPosition::with('department')->get();

        $departments = Department::all();

        return view('users.hr.employees.create', compact('applicant', 'positions', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'date_of_birth' => 'required|date',
            'job_position_id' => 'required|exists:job_positions,id',
            'photo' => 'nullable|image|max:2048',
            'salary' => 'required|numeric|min:0',
            'leave_credit' => 'required|numeric|min:0'
        ]);

        $password = 'password123'; // You might want to generate a random password

        // Create user account
        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($password)
        ]);

        $user->assignRole('employee');

        // Create employee profile
        $employee = EmployeeProfile::create([
            'user_id' => $user->id,
            'job_position_id' => $validated['job_position_id'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'date_of_birth' => $validated['date_of_birth'],
            'salary' => $validated['salary'],
            'leave_credit' => $validated['leave_credit']
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('employees', 'public');
            $employee->update(['photo' => $path]);
        }

        if ($request->filled('applicant_id')) {
            $applicant = JobApplicant::find($request->applicant_id);
            if ($applicant) {
                $applicant->update(['status' => 'hired']);
            }
        }

        // Send credentials email
        try {
            Mail::to($user->email)
                ->send(new EmployeeCredentials($user, $password));
        } catch (\Exception $e) {
            report($e); // Log the error but don't fail the request
        }

        return redirect()
            ->route('hr.employees.index')
            ->with('success', 'Employee created successfully');
    }

    public function show(EmployeeProfile $employee)
    {
        $employee->load(['user', 'position']);
        return view('users.hr.employees.show', compact('employee'));
    }

    public function edit(EmployeeProfile $employee)
    {
        $employee->load(['user', 'position.department']);
        $positions = JobPosition::with('department')->get();
        $departments = Department::all();

        return view('users.hr.employees.edit', compact('employee', 'positions', 'departments'));
    }

    public function update(Request $request, EmployeeProfile $employee)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $employee->user_id,
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'date_of_birth' => 'required|date',
            'job_position_id' => 'required|exists:job_positions,id',
            'photo' => 'nullable|image|max:2048',
            'salary' => 'required|numeric|min:0',
            'leave_credit' => 'required|numeric|min:0'
        ]);

        // Update user
        $employee->user->update([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email']
        ]);

        // Update employee
        $employee->update([
            'job_position_id' => $validated['job_position_id'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'date_of_birth' => $validated['date_of_birth'],
            'salary' => $validated['salary'],
            'leave_credit' => $validated['leave_credit']
        ]);

        if ($request->hasFile('photo')) {
            if ($employee->photo) {
                Storage::disk('public')->delete($employee->photo);
            }
            $path = $request->file('photo')->store('employees', 'public');
            $employee->update(['photo' => $path]);
        }

        return redirect()
            ->route('hr.employees.show', $employee)
            ->with('success', 'Employee updated successfully');
    }

    public function destroy(EmployeeProfile $employee)
    {
        if ($employee->photo) {
            Storage::disk('public')->delete($employee->photo);
        }

        $employee->user->delete();
        $employee->delete();

        return redirect()
            ->route('hr.employees.index')
            ->with('success', 'Employee deleted successfully');
    }

    public function toggleTeacher(EmployeeProfile $employee)
    {
        try {
            $user = $employee->user;

            if ($user->hasRole('teacher')) {
                // Remove teacher role
                $user->removeRole('teacher');


                $message = 'Teacher role removed successfully';
            } else {
                // Assign teacher role
                $user->assignRole('teacher');

                // Create teacher profile if doesn't exist
                if (!$user->profile) {
                    Profile::create([
                        'user_id' => $user->id,
                        'first_name' => $employee->first_name,
                        'last_name' => $employee->last_name,
                        'address' => $employee->address,
                        'contact_no' => $employee->phone,
                        'image' => $employee->photo // Use employee photo if available
                    ]);
                }

                $message = 'Teacher role and profile created successfully';
            }

            return redirect()
                ->back()
                ->with('message', $message);
        } catch (\Exception $e) {
            report($e);
            return redirect()
                ->back()
                ->with('error', 'Failed to update teacher role: ' . $e->getMessage());
        }
    }

    public function print($id){
        $employee = EmployeeProfile::findOrFail($id);
        return view('users.hr.employees.print', compact('employee'));
    }
}
