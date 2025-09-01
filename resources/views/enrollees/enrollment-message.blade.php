<x-landing-page.base>
    <main
        class="min-h-[calc(100vh-64px)] w-full flex items-center justify-center bg-gradient-to-br from-blue-400 to-indigo-600 p-4">
        <div class="bg-white rounded-xl shadow-2xl p-8 sm:p-12 text-center max-w-lg w-full">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-6">
                Thanks for answering the Student Information Application Form
            </h2>
            <p class="text-gray-600 mb-8">
                Your application has been received. You can download a copy of your form for your records.
            </p>

            {{-- The route should point to the print view or a PDF download action --}}
            <a href="{{ route('enrollment.print', $student->id) }}"
                class="inline-block w-full sm:w-auto bg-blue-500 hover:bg-blue-600 text-white font-bold text-lg py-4 px-10 rounded-lg shadow-md transition-transform transform hover:scale-105 duration-300">
                Download Student Application Form
            </a>
        </div>
    </main>

</x-landing-page.base>
