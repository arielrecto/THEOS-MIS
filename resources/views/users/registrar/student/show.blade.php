<x-dashboard.registrar.base>
    <x-dashboard.page-title :title="_('Student Record')" :back_url="route('registrar.students.index')" />
    <x-notification-message />

    <!-- Student Profile Header -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
            <div class="md:col-span-1 flex justify-center md:justify-start">
                <div class="avatar">
                    <div class="w-24 h-24 rounded-full ring-2 ring-accent ring-offset-2 overflow-hidden">
                        @if($student->profilePicture)
                            <img class="object-cover w-full h-full"
                                 src="{{ asset($student->profilePicture->file_dir) }}"
                                 alt="Profile Photo">
                        @else
                            <img class="object-cover w-full h-full"
                                 src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}"
                                 alt="Profile Photo">
                        @endif
                    </div>
                </div>
            </div>

            <div class="md:col-span-5 flex flex-col justify-center">
                <h2 class="text-2xl font-bold truncate">{{ $student->name }}</h2>
                <p class="text-gray-600 mt-1 truncate">LRN: {{ $student?->studentProfile?->lrn ?? 'N/A' }}</p>

                <div class="mt-3 flex flex-col sm:flex-row sm:items-center gap-2">
                    <p class="text-sm text-gray-500">
                        <span class="font-medium">Contact:</span>
                        <span class="ml-1">{{ $student?->studentProfile?->contact_number ?? 'N/A' }}</span>
                    </p>

                    <p class="text-sm text-gray-500">
                        <span class="font-medium">Email:</span>
                        <span class="ml-1 truncate">{{ $student?->email ?? 'N/A' }}</span>
                    </p>
                </div>
            </div>

            <div class="md:col-span-6 flex flex-col gap-2">
                <!-- Mobile: Stack buttons vertically -->
                <div class="flex flex-col md:flex-row gap-2 md:justify-end">
                    <a href="{{ route('registrar.students.data-report', $student->id) }}"
                       target="_blank"
                       class="btn btn-outline btn-accent btn-sm w-full md:w-40">
                        <i class="fi fi-rr-document mr-2"></i>
                        Data Report
                    </a>
                    <a href="{{ route('registrar.students.good-moral', $student->id) }}"
                       target="_blank"
                       class="btn btn-outline btn-accent btn-sm w-full md:w-40">
                        <i class="fi fi-rr-diploma mr-2"></i>
                        Good Moral
                    </a>
                    <a href="{{ route('registrar.students.form-137', $student->id) }}"
                       target="_blank"
                       class="btn btn-outline btn-accent btn-sm w-full md:w-40">
                        <i class="fi fi-rr-document mr-2"></i>
                        Form 137
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Student Information -->
        <div class="col-span-1 lg:col-span-4">
            <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6 mb-6">
                <h3 class="text-lg font-bold mb-4">Personal Information</h3>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Date of Birth</p>
                            <p class="mt-1">{{ $student?->studentProfile?->birthdate ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Contact</p>
                            <p class="mt-1">{{ $student?->studentProfile?->contact_number ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Address</p>
                        <p class="mt-1 break-words">
                            {{ $student?->studentProfile?->street ?? '' }}
                            {{ $student?->studentProfile?->barangay ?? '' }}
                            {{ $student?->studentProfile?->city ?? '' }}
                            {{ $student?->studentProfile?->province ?? '' }}
                        </p>
                    </div>

                    <div class="pt-4 border-t">
                        <p class="text-sm font-medium text-gray-500">Parent/Guardian</p>
                        <p class="mt-1 font-medium">{{ $student?->studentProfile?->parent_name ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-500">{{ $student?->studentProfile?->relationship ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Payment Summary Card -->
            <div class="bg-white rounded-lg shadow-lg p-4 lg:p-6">
                <h3 class="text-lg font-bold mb-4">Payment Summary</h3>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-success/10 rounded-lg p-4">
                        <p class="text-xs text-gray-600 mb-1">Total Paid</p>
                        <p class="text-xl font-bold text-success">
                            ₱{{ number_format($paymentStats['total_paid'], 2) }}
                        </p>
                    </div>

                    <div class="bg-warning/10 rounded-lg p-4">
                        <p class="text-xs text-gray-600 mb-1">Pending</p>
                        <p class="text-xl font-bold text-warning">
                            ₱{{ number_format($paymentStats['total_pending'], 2) }}
                        </p>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Total Payments:</span>
                        <span class="font-bold">{{ $paymentStats['total_count'] }}</span>
                    </div>
                    <div class="flex items-center justify-between mt-2">
                        <span class="text-sm text-gray-600">Payment Rate:</span>
                        <span class="font-bold {{ $paymentStats['payment_rate'] >= 80 ? 'text-success' : 'text-warning' }}">
                            {{ number_format($paymentStats['payment_rate'], 1) }}%
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-span-1 lg:col-span-8 space-y-6">
            <!-- Academic Records -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-4 border-b">
                    <form method="GET" class="flex flex-col sm:flex-row sm:items-center gap-3">
                        <div class="form-control w-full sm:w-auto">
                            <select name="academic_year"
                                    onchange="this.form.submit()"
                                    class="select select-bordered w-full">
                                <option value="">{{ __('All Academic Years') }}</option>
                                @foreach($academicYears as $year)
                                    <option value="{{ $year->id }}"
                                            {{ request('academic_year') == $year->id ? 'selected' : '' }}>
                                        {{ $year->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @if(request('academic_year'))
                            <a href="{{ route('registrar.students.show', $student->id) }}"
                               class="btn btn-ghost btn-sm">
                                <i class="fi fi-rr-refresh mr-2"></i>
                                Clear
                            </a>
                        @endif
                    </form>
                </div>

                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold">Academic Records</h3>
                        @if(request('academic_year'))
                            <span class="badge badge-accent">
                                {{ $academicYears->find(request('academic_year'))->name }}
                            </span>
                        @endif
                    </div>

                    <!-- Enrolled Subjects -->
                    <div class="bg-base-100 rounded-lg shadow-sm p-4 mb-6">
                        <h4 class="text-base font-medium mb-3">Enrolled Subjects</h4>

                        @php
                            $profile = $student?->studentProfile;
                            $selectedRecord = null;
                            if($profile) {
                                if(request('academic_year')) {
                                    $selectedRecord = $profile->academicRecords->firstWhere('academic_year_id', request('academic_year'));
                                }
                                $selectedRecord = $selectedRecord ?? $profile->academicRecords->sortByDesc('id')->first();
                            }
                        @endphp

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @php
                                $studentClassrooms = $student->asStudentClassrooms ?? collect();
                            @endphp

                            @forelse($studentClassrooms as $classroomStudent)
                                @php
                                    $classroom = $classroomStudent->classroom ?? $classroomStudent;
                                    $subject = $classroom->subject ?? null;
                                    $matchedGrade = null;
                                    if ($selectedRecord && $selectedRecord->grades && $subject) {
                                        $matchedGrade = $selectedRecord->grades->firstWhere('subject', $subject->name);
                                    }
                                @endphp

                                <div class="flex items-center justify-between bg-white rounded-md p-3 border">
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-800 truncate">
                                            {{ $subject->name ?? ($classroom->name ?? 'N/A') }}
                                        </p>
                                        <p class="text-xs text-gray-500 truncate">
                                            {{ $classroom->name ?? 'N/A' }}
                                        </p>
                                    </div>

                                    <div class="text-right">
                                        @if($matchedGrade)
                                            <div class="text-sm font-semibold {{ $matchedGrade->grade >= 75 ? 'text-success' : 'text-error' }}">
                                                {{ number_format($matchedGrade->grade, 1) }}
                                            </div>
                                            <span class="badge badge-xs {{ $matchedGrade->grade >= 75 ? 'badge-success' : 'badge-error' }}">
                                                {{ $matchedGrade->remarks ?? 'N/A' }}
                                            </span>
                                        @else
                                            <div class="text-sm text-gray-400">—</div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-2 text-sm text-gray-500 text-center py-4">
                                    No enrolled classrooms found
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Academic Records Table -->
                    <div class="hidden md:block">
                        @forelse($student?->studentProfile?->academicRecords ?? [] as $record)
                            <div class="mb-8 last:mb-0">
                                <div class="flex justify-between items-center mb-4">
                                    <div>
                                        <h4 class="text-lg font-medium">Grade {{ $record?->grade_level ?? 'N/A' }}</h4>
                                        <p class="text-sm text-gray-600">{{ $record?->academicYear?->name ?? 'N/A' }}</p>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <div class="text-right">
                                            <span class="text-2xl font-bold {{ $record?->average >= 75 ? 'text-success' : 'text-error' }}">
                                                {{ number_format($record?->average ?? 0, 1) }}%
                                            </span>
                                            <div class="text-sm text-gray-500">Average</div>
                                        </div>
                                        <a href="{{ route('registrar.students.print', ['student' => $student->id, 'record' => $record->id]) }}"
                                           target="_blank"
                                           class="btn btn-ghost btn-sm">
                                            <i class="fi fi-rr-print mr-2"></i>
                                            Print
                                        </a>
                                    </div>
                                </div>

                                <div class="overflow-x-auto bg-base-100 rounded-lg border">
                                    <table class="table table-zebra w-full">
                                        <thead>
                                            <tr>
                                                <th>Subject</th>
                                                <th class="text-right">Grade</th>
                                                <th class="text-right">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($record?->grades ?? [] as $grade)
                                                <tr>
                                                    <td>{{ $grade?->subject ?? 'N/A' }}</td>
                                                    <td class="text-right font-medium">
                                                        {{ number_format($grade?->grade ?? 0, 1) }}
                                                    </td>
                                                    <td class="text-right">
                                                        <span class="badge {{ $grade?->grade >= 75 ? 'badge-success' : 'badge-error' }}">
                                                            {{ $grade?->remarks ?? 'N/A' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <i class="fi fi-rr-book-open-cover text-4xl text-gray-400 mb-3"></i>
                                <p class="text-gray-500">No academic records found</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Mobile View -->
                    <div class="md:hidden space-y-4">
                        @forelse($student?->studentProfile?->academicRecords ?? [] as $record)
                            <div class="bg-base-100 rounded-lg border p-4">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h4 class="font-medium">Grade {{ $record?->grade_level ?? 'N/A' }}</h4>
                                        <p class="text-xs text-gray-500">{{ $record?->academicYear?->name ?? 'N/A' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-lg font-bold {{ $record?->average >= 75 ? 'text-success' : 'text-error' }}">
                                            {{ number_format($record?->average ?? 0, 1) }}%
                                        </span>
                                    </div>
                                </div>

                                <details>
                                    <summary class="text-sm text-gray-600 cursor-pointer">
                                        View Subjects ({{ $record?->grades->count() ?? 0 }})
                                    </summary>
                                    <div class="mt-2 space-y-2">
                                        @foreach($record?->grades ?? [] as $grade)
                                            <div class="flex justify-between text-sm">
                                                <span>{{ $grade->subject }}</span>
                                                <span class="font-medium {{ $grade->grade >= 75 ? 'text-success' : 'text-error' }}">
                                                    {{ number_format($grade->grade, 1) }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </details>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                <i class="fi fi-rr-book-open-cover text-3xl mb-2"></i>
                                <p>No records found</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Payment History Section -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-6">Payment History</h3>

                    <!-- Payment Chart -->
                    @if($payments->count() > 0)
                        <div class="mb-6 bg-base-100 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-gray-600 mb-4">Payment Trends</h4>
                            <canvas id="paymentChart" class="w-full" style="max-height: 250px;"></canvas>
                        </div>
                    @endif

                    <!-- Payment Table (Desktop) -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Payment For</th>
                                    <th>Method</th>
                                    <th class="text-right">Amount</th>
                                    <th class="text-center">Status</th>
                                    <th>Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->created_at->format('M d, Y') }}</td>
                                        <td>{{ $payment->paymentAccount?->name ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge badge-sm badge-ghost">
                                                {{ $payment->payment_method ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="text-right font-semibold">
                                            ₱{{ number_format($payment->amount, 2) }}
                                        </td>
                                        <td class="text-center">
                                            @if($payment->status === 'approved')
                                                <span class="badge badge-success badge-sm">Approved</span>
                                            @elseif($payment->status === 'pending')
                                                <span class="badge badge-warning badge-sm">Pending</span>
                                            @elseif($payment->status === 'rejected')
                                                <span class="badge badge-error badge-sm">Rejected</span>
                                            @else
                                                <span class="badge badge-ghost badge-sm">{{ ucfirst($payment->status) }}</span>
                                            @endif
                                        </td>
                                        <td class="text-sm text-gray-600">
                                            {{ Str::limit($payment->note, 30) ?? '—' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-8 text-gray-500">
                                            <i class="fi fi-rr-receipt text-4xl mb-2"></i>
                                            <p>No payment history found</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Payment Cards (Mobile) -->
                    <div class="md:hidden space-y-3">
                        @forelse($payments as $payment)
                            <div class="bg-base-100 rounded-lg border p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <p class="font-medium text-sm">{{ $payment->paymentAccount?->name ?? 'N/A' }}</p>
                                        <p class="text-xs text-gray-500">{{ $payment->created_at->format('M d, Y') }}</p>
                                    </div>
                                    @if($payment->status === 'approved')
                                        <span class="badge badge-success badge-sm">Approved</span>
                                    @elseif($payment->status === 'pending')
                                        <span class="badge badge-warning badge-sm">Pending</span>
                                    @else
                                        <span class="badge badge-error badge-sm">Rejected</span>
                                    @endif
                                </div>
                                <div class="flex justify-between items-center mt-3">
                                    <span class="badge badge-ghost badge-sm">{{ $payment->payment_method }}</span>
                                    <span class="text-lg font-bold">₱{{ number_format($payment->amount, 2) }}</span>
                                </div>
                                @if($payment->note)
                                    <p class="text-xs text-gray-500 mt-2">{{ $payment->note }}</p>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                <i class="fi fi-rr-receipt text-4xl mb-2"></i>
                                <p>No payment history</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($payments->hasPages())
                        <div class="mt-6">
                            {{ $payments->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('paymentChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($chartData['labels']),
                        datasets: [{
                            label: 'Payment Amount',
                            data: @json($chartData['amounts']),
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return '₱' + context.parsed.y.toLocaleString('en-PH', {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        });
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return '₱' + value.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
    @endpush
</x-dashboard.registrar.base>
