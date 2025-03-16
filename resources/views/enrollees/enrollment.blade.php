<x-landing-page.base>
    <section class="flex justify-center items-center min-h-screen">
        <div class="p-6 mx-auto w-1/2 max-w-lg bg-white rounded-2xl shadow-lg">
            <h2 class="text-2xl font-bold text-gray-800">Enrollment Now Open!</h2>
            <p class="mt-2 text-gray-600">Academic Year: <span class="font-semibold">{{date('Y', strtotime($enrollment->academicYear->start_date)) . ' - ' . date('Y', strtotime($enrollment->academicYear->end_date))}}</span></p>
            <p class="text-gray-600">Start Date: <span class="font-semibold">{{date('F d, Y', strtotime($enrollment->start_date))}}</span></p>
            <p class="text-gray-600">End Date: <span class="font-semibold">{{date('F d, Y', strtotime($enrollment->end_date))}}</span></p>
            <p class="mt-4">
                <span class="px-3 py-1 text-sm font-semibold text-white bg-green-500 rounded-full">
                    Enrollment Open
                </span>
            </p>
            <p class="flex flex-col gap-2 p-5 text-gray-600 bg-gray-50 rounded-lg min-h-32">
                <span>
                    Description:
                </span>

                <span>
                    {{ $enrollment->description }}
                </span>
            </p>
            <p>
                Please click the button below to enroll.
            </p>
            <a href="{{route('enrollment.form', ['enrollment' => $enrollment->id])}}"
                class="block px-4 py-2 mt-6 font-semibold text-center text-white bg-blue-600 rounded-lg hover:bg-blue-700">
               Enroll Now
            </a>
        </div>
    </section>
</x-landing-page.base>
