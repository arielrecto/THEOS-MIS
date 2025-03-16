<x-app-layout>
    <div class="main h-screen">
        <div class="min-h-96 flex justify-center">
            <div class="w-3/6 flex flex-col gap-2 panel mt-10">
                <x-dashboard.page-title :title="_('Generate QR Code')" :back_url="route('teacher.classrooms.show', ['classroom' => $classroom->id])"/>
                    <form action="{{route('teacher.classrooms.attendances.store')}}" method="post" class="flex flex-col gap-5">
                        @csrf

                        <div class="flex justify-center gap-2 w-full">
                            <div>
                                <label for="" class="input-generic-label">Generated QR</label>
                                <div class="h-32 w-32">
                                {!! QrCode::generate($attendance_code) !!}
                                    <p class="text-gray-500 text-xs">Code: {{$attendance_code}}</p>
                                </div>
                            </div>

                            <input type="hidden" name="attendance_code" value="{{$attendance_code}}">
                        </div>

                        <input type="hidden" name="classroom_id" value="{{$classroom->id}}">

                        <label for="" class="input-generic-label">Duration</label>
                        <div class="grid grid-cols-2 grid-flow-row gap-2">
                            <div class="flex flex-col gap-2">
                                <label for="" class="input-generic-label">Start Time</label>
                                <input type="time" name="start_time" class="input-generic">
                                @if ($errors->has('start_time'))
                                    <p class="text-xs text-error">{{$errors->first('start_time')}}</p>
                                @endif

                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="" class="input-generic-label">End Time</label>
                                <input type="time" name="end_time" class="input-generic">
                                @if ($errors->has('end_time'))
                                <p class="text-xs text-error">{{$errors->first('end_time')}}</p>
                            @endif
                            </div>
                        </div>
                        <button class="btn btn-sm btn-accent">Save</button>
                    </form>
            </div>
        </div>
    </div>
</x-app-layout>
