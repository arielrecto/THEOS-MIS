<x-app-layout>
    <div class="main h-screen">
        <div class="min-h-96 flex justify-center">
            <div class="w-3/6 flex flex-col gap-2 panel mt-10" x-data="QrScanner">
                <x-dashboard.page-title :title="_('Attendance Scanner')" :back_url="route('teacher.classrooms.show', ['classroom' => $classroomId])"/>

                    <div x-ref="reader" id="reader" class="min-h-32">

                    </div>


                    <div class="mt-20">
                        <h1 class="text-lg py-5 text-accent font-bold">Attendances</h1>
                        <table class="table">
                            <!-- head -->
                            <thead>
                                <tr class="bg-accent text-white">
                                    <th></th>
                                    <th>Attendance Code</th>
                                    <th>Time</th>
                                    <th>Date</th>
                                    {{-- <th>Job</th>
                                        <th>Favorite Color</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <!-- row 1 -->

                                    <template x-for="student in  students">
                                        <tr>
                                        <td><span x-text="hello world"></span></td>
                                        {{-- <td>{{ date('H:s A', strtotime($s_attendance->created_at))}}</td>
                                        <td>{{ date('F d, Y', strtotime($s_attendance->created_at))}}</td> --}}
                                        </tr>
                                    </template>

                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
</x-app-layout>
