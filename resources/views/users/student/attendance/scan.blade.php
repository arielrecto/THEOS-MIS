<x-dashboard.student.base>
    <div class="container p-6 mx-auto">
        <div class="max-w-lg mx-auto">
            <!-- Header -->
            <div class="mb-6 text-center">
                <h1 class="text-2xl font-bold text-gray-800">Scan Attendance QR</h1>
                <p class="text-gray-600">Scan the QR code displayed by your teacher</p>
            </div>



            <!-- Scanner Container -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden" x-data="QrScanner">
                <div class="p-6 border-b">

                    <template x-if="'message' in errors">
                        <p class="text-xs text-error p-2">
                            <span x-text="errors?.message"></span>
                        </p>
                    </template>

                    <div x-ref="reader" id="reader" class="w-full"></div>
                </div>


                <input type="hidden" x-model="type = 'student'">

                <!-- Status Messages -->
                <div class="p-6">
                    <!-- Loading State -->
                    <div x-show="loading" class="flex items-center justify-center gap-2 text-accent">
                        <i class="fi fi-rr-spinner animate-spin"></i>
                        <span>Processing...</span>
                    </div>

                    <!-- Error Message -->
                    <div x-show="error"
                         x-text="error"
                         class="text-center text-sm text-red-600">
                    </div>

                    <!-- Success Message -->
                    <div x-show="success"
                         class="text-center text-sm text-green-600">
                        <i class="fi fi-rr-check mr-1"></i>
                        <span x-text="success"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/html5-qrcode"></script>
    @endpush
</x-dashboard.student.base>
