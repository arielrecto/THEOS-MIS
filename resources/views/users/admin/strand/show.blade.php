<x-dashboard.admin.base>
    <x-dashboard.page-title :title="_('Grade Level')" :back_url="route('admin.strands.index')" />
    <div class="panel flex flex-col gap-4">

        <h1 class="text-lg sm:text-xl font-bold text-accent capitalize">
            {{ $strand->acronym }} - {{ $strand->name }}
        </h1>

        <!-- Description: reduce fixed height, allow wrapping -->
        <div class="min-h-20 p-3 rounded-lg bg-gray-100 text-gray-500 text-sm">
            {{ $strand->descriptions }}
        </div>

        <!-- Summary card(s) — responsive grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
            <x-card label="Classrooms" total="{{ $strand->classrooms()->count() }}"
                class="shadow-none border border-accent" />
            <x-card label="Tuition Fees" total="{{ $strand->tuitionFees()->count() }}"
                class="shadow-none border border-accent" />
        </div>

        <!-- Tuition Fees Section -->
        <div class="mt-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-accent">Assigned Tuition Fees</h2>
                <button onclick="tuitionFeeModal.showModal()" class="btn btn-sm btn-accent gap-2">
                    <i class="fi fi-rr-edit"></i>
                    <span class="hidden sm:inline">Edit Fees</span>
                </button>
            </div>

            @if ($strand->tuitionFees->count() > 0)
                <!-- Desktop Table -->
                <div class="hidden md:block overflow-x-auto bg-white rounded-lg shadow-sm">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Fee Name</th>
                                <th>Type</th>
                                <th>Bracket</th>
                                <th>Amount</th>
                                <th>Payment Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($strand->tuitionFees as $fee)
                                <tr class="hover:bg-gray-50">
                                    <td class="font-medium">{{ $fee->name }}</td>
                                    <td>
                                        <span class="badge badge-sm badge-outline">{{ $fee->type }}</span>
                                    </td>
                                    <td>{{ $fee->bracket->name ?? 'N/A' }}</td>
                                    <td class="font-semibold text-accent">
                                        ₱{{ number_format($fee->amount, 2) }}
                                    </td>
                                    <td>
                                        <div class="flex flex-wrap gap-1">
                                            @if ($fee->is_monthly)
                                                <span class="badge badge-info badge-xs">Monthly</span>
                                            @endif
                                            @if ($fee->is_onetime_fee)
                                                <span class="badge badge-warning badge-xs">One-time</span>
                                            @endif
                                            @if ($fee->payment_agreement == 'full_payment')
                                                <span class="badge badge-success badge-xs">Full Payment</span>
                                            @elseif($fee->payment_agreement == 'installment')
                                                <span class="badge badge-primary badge-xs">Installment</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="font-bold bg-gray-50">
                                <td colspan="3" class="text-right">Total Fees:</td>
                                <td class="text-accent text-lg">
                                    ₱{{ number_format($strand->tuitionFees->sum('amount'), 2) }}
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="md:hidden space-y-3">
                    @foreach ($strand->tuitionFees as $fee)
                        <div class="bg-white rounded-lg shadow-sm p-4 border">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-sm truncate">{{ $fee->name }}</h4>
                                    <p class="text-xs text-gray-500 mt-1">{{ $fee->bracket->name ?? 'N/A' }}</p>
                                </div>
                                <span class="badge badge-sm badge-outline ml-2">{{ $fee->type }}</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex flex-wrap gap-1">
                                    @if ($fee->is_monthly)
                                        <span class="badge badge-info badge-xs">Monthly</span>
                                    @endif
                                    @if ($fee->is_onetime_fee)
                                        <span class="badge badge-warning badge-xs">One-time</span>
                                    @endif
                                    @if ($fee->payment_agreement == 'full_payment')
                                        <span class="badge badge-success badge-xs">Full</span>
                                    @elseif($fee->payment_agreement == 'installment')
                                        <span class="badge badge-primary badge-xs">Installment</span>
                                    @endif
                                </div>
                                <span class="font-bold text-accent text-lg ml-2">
                                    ₱{{ number_format($fee->amount, 2) }}
                                </span>
                            </div>
                        </div>
                    @endforeach

                    <!-- Mobile Total -->
                    <div class="bg-gray-50 rounded-lg p-4 border border-accent">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-gray-700">Total Fees:</span>
                            <span class="font-bold text-accent text-xl">
                                ₱{{ number_format($strand->tuitionFees->sum('amount'), 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-lg border border-dashed border-gray-300 p-8 text-center">
                    <i class="fi fi-rr-money-bill-wave text-4xl text-gray-400 mb-3"></i>
                    <p class="text-gray-600 mb-4">No tuition fees assigned yet</p>
                    <button onclick="tuitionFeeModal.showModal()" class="btn btn-accent btn-sm gap-2">
                        <i class="fi fi-rr-plus"></i>
                        Assign Fees
                    </button>
                </div>
            @endif
        </div>

        <!-- Classrooms Section -->
        <h2 class="text-lg font-bold text-accent mt-6">Classrooms</h2>

        <!-- Classrooms grid: responsive columns, cards adapt to small viewports (320px width) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse ($strand->classrooms as $classroom)
                <div class="rounded-lg border border-accent overflow-hidden flex flex-col">
                    <!-- Card header: image + text arranged horizontally on larger screens,
                         stacked on very small screens. No absolute positioning. -->
                    <a href="#" class="block bg-accent p-3 sm:p-4 flex items-start gap-3">
                        <div class="flex-1 min-w-0">
                            <h3
                                class="text-base sm:text-lg font-semibold text-primary capitalize leading-tight truncate">
                                {{ $classroom->strand->name }}
                            </h3>

                            <p class="text-sm text-primary mt-1 truncate">
                                {{ $classroom->teacher->name }}
                            </p>
                        </div>

                        <!-- Responsive avatar: smaller on narrow screens -->
                        <img src="{{ $classroom->teacher->profile->image }}" alt="teacher"
                            class="h-12 w-12 sm:h-16 sm:w-16 object-cover rounded-full flex-shrink-0">
                    </a>

                    <div class="p-3">
                        <h4 class="text-sm uppercase text-gray-700 truncate">
                            {{ $classroom->name }} - {{ $classroom->strand->acronym }}
                        </h4>
                    </div>
                </div>
            @empty
                <div class="rounded-lg border border-accent flex items-center justify-center p-6">
                    <p class="text-base font-semibold text-accent text-center">No Classrooms</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Tuition Fee Modal -->
    <dialog id="tuitionFeeModal" class="modal">
        <div class="modal-box max-w-4xl">
            <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
                <i class="fi fi-rr-money-bill-wave"></i>
                Set Tuition Fees for {{ $strand->name }}
            </h3>

            <form action="{{ route('admin.strands.tuition-fees.update', $strand->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Current Assigned Fees -->
                @if ($strand->tuitionFees->count() > 0)
                    <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                        <h4 class="font-semibold text-sm mb-3 text-blue-800">Currently Assigned Fees</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($strand->tuitionFees as $fee)
                                <div class="badge badge-accent gap-2">
                                    {{ $fee->name }} - ₱{{ number_format($fee->amount, 2) }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Fee Brackets with Checkboxes -->
                <div class="space-y-4 max-h-96 overflow-y-auto">
                    @foreach ($brackets as $bracket)
                        <div class="border rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <h4 class="font-semibold">{{ $bracket->name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $bracket->description }}</p>
                                </div>
                                <span class="badge {{ $bracket->is_active ? 'badge-success' : 'badge-ghost' }}">
                                    {{ $bracket->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>

                            @if ($bracket->fees->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    @foreach ($bracket->fees as $fee)
                                        <label
                                            class="flex items-start gap-3 p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                                            <input type="checkbox" name="tuition_fees[]" value="{{ $fee->id }}"
                                                {{ $strand->tuitionFees->contains($fee->id) ? 'checked' : '' }}
                                                class="checkbox checkbox-sm checkbox-accent mt-1"
                                                data-amount="{{ $fee->amount }}">
                                            <div class="flex-1">
                                                <div class="font-medium text-sm">{{ $fee->name }}</div>
                                                <div class="flex items-center gap-2 mt-1 flex-wrap">
                                                    <span
                                                        class="text-accent font-semibold">₱{{ number_format($fee->amount, 2) }}</span>
                                                    <span
                                                        class="badge badge-xs badge-outline">{{ $fee->type }}</span>
                                                    @if ($fee->is_monthly)
                                                        <span class="badge badge-xs badge-info">Monthly</span>
                                                    @endif
                                                    @if ($fee->is_onetime_fee)
                                                        <span class="badge badge-xs badge-warning">One-time</span>
                                                    @endif
                                                    @if ($fee->payment_agreement == 'full_payment')
                                                        <span class="badge badge-xs badge-success">Full Payment</span>
                                                    @elseif($fee->payment_agreement == 'installment')
                                                        <span class="badge badge-xs badge-primary">Installment</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500 text-center py-4">No fees in this bracket</p>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Total Calculation -->
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <div class="flex justify-between items-center">
                        <span class="font-semibold">Selected Fees Total:</span>
                        <span class="text-2xl font-bold text-accent" id="totalAmount">
                            ₱{{ number_format($strand->tuitionFees->sum('amount'), 2) }}
                        </span>
                    </div>
                </div>

                <div class="modal-action">
                    <button type="button" onclick="tuitionFeeModal.close()" class="btn btn-ghost">Cancel</button>
                    <button type="submit" class="btn btn-accent">
                        <i class="fi fi-rr-check"></i>
                        Update Tuition Fees
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('tuitionFeeModal');
                const checkboxes = modal.querySelectorAll('input[name="tuition_fees[]"]');
                const totalAmount = document.getElementById('totalAmount');

                function updateTotal() {
                    let total = 0;
                    checkboxes.forEach(checkbox => {
                        if (checkbox.checked) {
                            total += parseFloat(checkbox.dataset.amount || 0);
                        }
                    });
                    totalAmount.textContent = '₱' + total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

                }

                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', updateTotal);
                });

                // Calculate initial total
                updateTotal();
            });
        </script>
    @endpush
</x-dashboard.admin.base>
