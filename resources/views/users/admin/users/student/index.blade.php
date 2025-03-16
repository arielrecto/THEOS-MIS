<x-dashboard.admin.base>
    <x-dashboard.page-title :back_url="route('admin.users.index')" :title="_('students')"  />
    <div class="panel flex flex-col gap-2">
        <div class="overflow-x-auto">
            <table class="table">
                <!-- head -->
                <thead>
                    <tr>
                        <th></th>
                        <th>name</th>
                        <th>email</th>
                        <th>Classrooms</th>
                        <th>Actions</th>
                        {{-- <th>Favorite Color</th> --}}
                    </tr>
                </thead>
                <tbody>
                    <!-- row 1 -->
                    @forelse ($students as $student)
                        <tr>
                            <th></th>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->asStudentClassrooms()->count() }}</td>
                            <td class="flex items-center gap-5">
                                <a href="{{route('admin.users.students.show', ['student' => $student->id])}}" class="btn btn-xs btn-accent">
                                    <i class="fi fi-rr-eye"></i>
                                </a>

                                <a href="{{route('admin.users.students.edit', ['student' => $student->id])}}" class="btn btn-xs btn-primary">
                                    <i class="fi fi-rr-edit"></i>
                                </a>

                                <form action="{{route('admin.users.students.destroy', ['student' => $student->id])}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-xs btn-error ">
                                        <i class="fi fi-rr-trash"></i>
                                    </button>
                                </form>
                            </td>
                            {{-- <td>Blue</td> --}}
                        </tr>
                    @empty
                        <tr>
                            <th>No studentss</th>

                        </tr>
                    @endforelse

                    {{-- <!-- row 2 -->
                <tr>
                  <th>2</th>
                  <td>Hart Hagerty</td>
                  <td>Desktop Support Technician</td>
                  <td>Purple</td>
                </tr>
                <!-- row 3 -->
                <tr>
                  <th>3</th>
                  <td>Brice Swyre</td>
                  <td>Tax Accountant</td>
                  <td>Red</td>
                </tr> --}}
                </tbody>
            </table>
        </div>
    </div>
</x-dashboard.admin.base>
