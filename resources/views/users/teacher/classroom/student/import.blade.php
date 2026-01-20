<x-dashboard.teacher.base>
    <div class="container mx-auto p-6 max-w-4xl">
        <div class="mb-6">
            <a href="{{ route('teacher.classrooms.students', $classroom->id) }}" class="btn btn-ghost btn-sm gap-2">
                <i class="fi fi-rr-arrow-left"></i>
                Back to Students
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">
                    <i class="fi fi-rr-upload"></i>
                    Bulk Student Import
                </h1>
                <p class="text-gray-600">
                    Import multiple students to <strong>{{ $classroom->name }}</strong>
                </p>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $classroom->strand->name }} - {{ $classroom->academicYear->school_year }}
                </p>
            </div>

            <x-notification-message />

            <!-- Instructions -->
            <div class="alert alert-info mb-6">
                <i class="fi fi-rr-info-circle text-xl"></i>
                <div>
                    <h3 class="font-bold">Instructions:</h3>
                    <ol class="list-decimal list-inside text-sm mt-2 space-y-1">
                        <li>Download the CSV template below</li>
                        <li>Fill in all required student information</li>
                        <li>Ensure all fields are filled correctly</li>
                        <li>Save the file as CSV format</li>
                        <li>Upload the completed CSV file</li>
                    </ol>
                </div>
            </div>

            <!-- Download Template -->
            <div class="card bg-base-100 border mb-6">
                <div class="card-body">
                    <h3 class="card-title text-lg">
                        <i class="fi fi-rr-download"></i>
                        Step 1: Download Template
                    </h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Download the CSV template with all required columns and sample data.
                    </p>
                    <a href="{{ route('teacher.classrooms.students.import.template') }}" class="btn btn-accent gap-2">
                        <i class="fi fi-rr-file-download"></i>
                        Download CSV Template
                    </a>
                </div>
            </div>

            <!-- Required Fields Info -->
            <div class="collapse collapse-arrow bg-base-200 mb-6">
                <input type="checkbox" />
                <div class="collapse-title text-lg font-medium">
                    <i class="fi fi-rr-list"></i>
                    View Required Fields
                </div>
                <div class="collapse-content">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <h4 class="font-semibold mb-2 text-primary">Account Information</h4>
                            <ul class="text-sm space-y-1">
                                <li>• Email (must be unique)</li>
                                <li>• Password (min 8 characters)</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-2 text-primary">Personal Information</h4>
                            <ul class="text-sm space-y-1">
                                <li>• LRN (12 digits, unique)</li>
                                <li>• Last Name, First Name</li>
                                <li>• Birthdate (YYYY-MM-DD format)</li>
                                <li>• Birthplace</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-2 text-primary">Address Information</h4>
                            <ul class="text-sm space-y-1">
                                <li>• House No, Street, Barangay</li>
                                <li>• City, Province, Zip Code</li>
                                <li>• Permanent Address (optional)</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-2 text-primary">Parent/Guardian Info</h4>
                            <ul class="text-sm space-y-1">
                                <li>• Parent Name, Relationship</li>
                                <li>• Contact Number, Occupation</li>
                                <li>• Mother/Guardian Info (optional)</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-2 text-primary">Academic Information</h4>
                            <ul class="text-sm space-y-1">
                                <li>• School Year (YYYY-YYYY format)</li>
                                <li>• Grade Level</li>
                                <li>• Type (new/transferee/returning)</li>
                                <li>• Preferred Track & Strand</li>
                                <li>• Modality (Face-to-Face/Online/Blended)</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Format Examples -->
                    <div class="mt-4 p-4 bg-info/10 rounded-lg border border-info">
                        <h4 class="font-semibold text-info mb-2">
                            <i class="fi fi-rr-info-circle"></i>
                            Format Examples
                        </h4>
                        <ul class="text-sm space-y-1">
                            <li>• <strong>School Year:</strong> 2024-2025, 2025-2026</li>
                            <li>• <strong>Birthdate:</strong> 2005-01-15 (YYYY-MM-DD)</li>
                            <li>• <strong>LRN:</strong> 123456789012 (exactly 12 digits)</li>
                            <li>• <strong>Contact Number:</strong> 09123456789</li>
                            <li>• <strong>Type:</strong> new, transferee, or returning</li>
                            <li>• <strong>Modality:</strong> Face-to-Face, Online, or Blended</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Upload Form -->
            <div class="card bg-base-100 border">
                <div class="card-body">
                    <h3 class="card-title text-lg mb-4">
                        <i class="fi fi-rr-cloud-upload"></i>
                        Step 2: Upload CSV File
                    </h3>

                    <form action="{{ route('teacher.classrooms.students.import.process', $classroom->id) }}"
                        method="POST" enctype="multipart/form-data" id="importForm">
                        @csrf

                        <div class="form-control mb-4">
                            <label class="label">
                                <span class="label-text font-semibold">Select CSV File</span>
                            </label>
                            <input type="file" name="csv_file" accept=".csv,.txt"
                                class="file-input file-input-bordered w-full" required id="csvFile">
                            <label class="label">
                                <span class="label-text-alt text-gray-500">
                                    Maximum file size: 5MB. Only CSV format accepted.
                                </span>
                            </label>
                            @error('csv_file')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- File Preview -->
                        <div id="filePreview" class="hidden mb-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <div class="flex items-center gap-3">
                                <i class="fi fi-rr-file-csv text-3xl text-blue-600"></i>
                                <div class="flex-1">
                                    <p class="font-medium" id="fileName"></p>
                                    <p class="text-sm text-gray-600" id="fileSize"></p>
                                </div>
                                <button type="button" onclick="clearFile()" class="btn btn-ghost btn-sm btn-circle">
                                    <i class="fi fi-rr-cross"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Warning -->
                        <div class="alert alert-warning mb-4">
                            <i class="fi fi-rr-exclamation-triangle"></i>
                            <div class="text-sm">
                                <p class="font-semibold">Important:</p>
                                <ul class="list-disc list-inside mt-1">
                                    <li>Ensure all email addresses are unique</li>
                                    <li>Ensure all LRN numbers are unique</li>
                                    <li>Invalid data will be skipped with error messages</li>
                                    <li>This action cannot be undone</li>
                                </ul>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="btn btn-primary gap-2" id="submitBtn">
                                <i class="fi fi-rr-upload"></i>
                                Import Students
                            </button>
                            <a href="{{ route('teacher.classrooms.students', $classroom->id) }}" class="btn btn-ghost">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Import Errors -->
            @if (session('import_errors') && count(session('import_errors')) > 0)
                <div class="mt-6">
                    <div class="alert alert-error">
                        <i class="fi fi-rr-exclamation-circle text-xl"></i>
                        <div class="w-full">
                            <h3 class="font-bold mb-2">Import Errors:</h3>
                            <div class="max-h-60 overflow-y-auto">
                                <ul class="text-sm space-y-1">
                                    @foreach (session('import_errors') as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            const csvFile = document.getElementById('csvFile');
            const filePreview = document.getElementById('filePreview');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            const submitBtn = document.getElementById('submitBtn');
            const importForm = document.getElementById('importForm');

            csvFile.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    fileName.textContent = file.name;
                    fileSize.textContent = formatFileSize(file.size);
                    filePreview.classList.remove('hidden');
                }
            });

            function clearFile() {
                csvFile.value = '';
                filePreview.classList.add('hidden');
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
            }

            importForm.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="loading loading-spinner"></span> Importing...';
            });
        </script>
    @endpush
</x-dashboard.teacher.base>
