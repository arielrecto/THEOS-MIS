<x-dashboard.student.base>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="mb-6">
                <a href="{{ route('student.enrollment.index') }}" class="btn btn-ghost btn-sm gap-2">
                    <i class="fi fi-rr-arrow-left"></i>
                    Back to List
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Status Badge -->
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-gray-800">
                            Enrollment Form Details
                        </h2>
                        <span
                            class="badge {{ $enrollment->status === 'pending'
                                ? 'badge-warning'
                                : ($enrollment->status === 'enrolled'
                                    ? 'badge-success'
                                    : 'badge-error') }}">
                            {{ ucfirst($enrollment->status) }}
                        </span>
                    </div>

                    <!-- Form Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Information -->
                        <div class="space-y-4">
                            <h3 class="font-medium text-gray-700">Basic Information</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">School Year</p>
                                    <p class="font-medium">{{ $enrollment->school_year }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Grade Level</p>
                                    <p class="font-medium">{{ $enrollment->grade_level }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Student Type</p>
                                    <p class="font-medium">{{ ucfirst($enrollment->type) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Timestamps -->
                        <div class="space-y-4">
                            <h3 class="font-medium text-gray-700">Submission Details</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">Submitted On</p>
                                    <p class="font-medium">{{ $enrollment->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Last Updated</p>
                                    <p class="font-medium">{{ $enrollment->updated_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Attached Documents -->
                        <div class="col-span-full">
                            <h3 class="font-medium text-gray-700 mb-4">Attached Documents</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @forelse($enrollment->attachments as $attachment)
                                    <div class="p-4 bg-gray-50 rounded-lg border">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="font-medium truncate">{{ $attachment->file_name }}</p>
                                                <p class="text-sm text-gray-500">
                                                    {{ number_format($attachment->file_size / 1024, 2) }} KB
                                                </p>
                                            </div>
                                            <a href="{{ Storage::url($attachment->file_dir) }}" target="_blank"
                                                class="btn btn-ghost btn-sm">
                                                <i class="fi fi-rr-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-span-full">
                                        <p class="text-gray-500 text-center">No documents attached</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tuition Fees Section -->
            @if ($strand && $strand->tuitionFees->count() > 0)
                @php
                    $fullPaymentFees = $strand->tuitionFees->where('payment_agreement', 'full');
                    $installmentFees = $strand->tuitionFees->where('payment_agreement', 'installment');
                @endphp

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-semibold text-gray-800">
                                Tuition Fees for {{ $strand->name }}
                            </h2>
                            <span class="badge badge-accent">
                                {{ $strand->tuitionFees->count() }} fees
                            </span>
                        </div>

                        <!-- Full Payment Section -->
                        @if ($fullPaymentFees->count() > 0)
                            <div class="mb-8">
                                <div class="flex items-center gap-2 mb-4">
                                    <h3 class="text-lg font-semibold text-green-700">
                                        <i class="fi fi-rr-money-bill-wave"></i>
                                        Full Payment Fees
                                    </h3>
                                    <span class="badge badge-success badge-sm">{{ $fullPaymentFees->count() }}
                                        fees</span>
                                </div>

                                <!-- Desktop Table -->
                                <div class="hidden md:block overflow-x-auto">
                                    <table class="table">
                                        <thead>
                                            <tr class="bg-green-50">
                                                <th>Fee Name</th>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Payment Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($fullPaymentFees as $fee)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="font-medium">{{ $fee->name }}</td>
                                                    <td>
                                                        <span
                                                            class="badge badge-sm badge-outline">{{ $fee->type }}</span>
                                                    </td>
                                                    <td class="font-semibold text-success">
                                                        ₱{{ number_format($fee->amount, 2) }}
                                                    </td>
                                                    <td>
                                                        <div class="flex flex-wrap gap-1">
                                                            @if ($fee->is_monthly)
                                                                <span class="badge badge-info badge-xs">Monthly</span>
                                                            @endif
                                                            @if ($fee->is_onetime_fee)
                                                                <span
                                                                    class="badge badge-warning badge-xs">One-time</span>
                                                            @endif
                                                            <span class="badge badge-success badge-xs">Full
                                                                Payment</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="font-bold bg-green-50">
                                                <td colspan="2" class="text-right">Full Payment Total:</td>
                                                <td class="text-success text-lg">
                                                    ₱{{ number_format($fullPaymentFees->sum('amount'), 2) }}
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <!-- Mobile Cards -->
                                <div class="md:hidden space-y-3">
                                    @foreach ($fullPaymentFees as $fee)
                                        <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                                            <div class="flex items-start justify-between mb-3">
                                                <div class="flex-1 min-w-0">
                                                    <h4 class="font-semibold text-sm truncate">{{ $fee->name }}</h4>
                                                    <span
                                                        class="badge badge-xs badge-outline mt-1">{{ $fee->type }}</span>
                                                </div>
                                                <span class="font-bold text-success text-lg ml-2">
                                                    ₱{{ number_format($fee->amount, 2) }}
                                                </span>
                                            </div>

                                            <div class="flex flex-wrap gap-1">
                                                @if ($fee->is_monthly)
                                                    <span class="badge badge-info badge-xs">Monthly</span>
                                                @endif
                                                @if ($fee->is_onetime_fee)
                                                    <span class="badge badge-warning badge-xs">One-time</span>
                                                @endif
                                                <span class="badge badge-success badge-xs">Full Payment</span>
                                            </div>
                                        </div>
                                    @endforeach

                                    <!-- Mobile Total -->
                                    <div class="bg-green-100 rounded-lg p-4 border-2 border-green-300">
                                        <div class="flex items-center justify-between">
                                            <span class="font-bold text-green-800">Full Payment Total:</span>
                                            <span class="font-bold text-success text-2xl">
                                                ₱{{ number_format($fullPaymentFees->sum('amount'), 2) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Installment Section -->
                        @if ($installmentFees->count() > 0)
                            <div class="mb-8">
                                <div class="flex items-center gap-2 mb-4">
                                    <h3 class="text-lg font-semibold text-blue-700">
                                        <i class="fi fi-rr-calendar"></i>
                                        Installment Fees
                                    </h3>
                                    <span class="badge badge-primary badge-sm">{{ $installmentFees->count() }}
                                        fees</span>
                                </div>

                                <!-- Desktop Table -->
                                <div class="hidden md:block overflow-x-auto">
                                    <table class="table">
                                        <thead>
                                            <tr class="bg-blue-50">
                                                <th>Fee Name</th>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Payment Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($installmentFees as $fee)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="font-medium">{{ $fee->name }}</td>
                                                    <td>
                                                        <span
                                                            class="badge badge-sm badge-outline">{{ $fee->type }}</span>
                                                    </td>
                                                    <td class="font-semibold text-primary">
                                                        ₱{{ number_format($fee->amount, 2) }}
                                                    </td>
                                                    <td>
                                                        <div class="flex flex-wrap gap-1">
                                                            @if ($fee->is_monthly)
                                                                <span class="badge badge-info badge-xs">Monthly</span>
                                                            @endif
                                                            @if ($fee->is_onetime_fee)
                                                                <span
                                                                    class="badge badge-warning badge-xs">One-time</span>
                                                            @endif
                                                            <span
                                                                class="badge badge-primary badge-xs">Installment</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="font-bold bg-blue-50">
                                                <td colspan="2" class="text-right">Installment Total:</td>
                                                <td class="text-primary text-lg">
                                                    ₱{{ number_format($installmentFees->sum('amount'), 2) }}
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <!-- Mobile Cards -->
                                <div class="md:hidden space-y-3">
                                    @foreach ($installmentFees as $fee)
                                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                                            <div class="flex items-start justify-between mb-3">
                                                <div class="flex-1 min-w-0">
                                                    <h4 class="font-semibold text-sm truncate">{{ $fee->name }}
                                                    </h4>
                                                    <span
                                                        class="badge badge-xs badge-outline mt-1">{{ $fee->type }}</span>
                                                </div>
                                                <span class="font-bold text-primary text-lg ml-2">
                                                    ₱{{ number_format($fee->amount, 2) }}
                                                </span>
                                            </div>

                                            <div class="flex flex-wrap gap-1">
                                                @if ($fee->is_monthly)
                                                    <span class="badge badge-info badge-xs">Monthly</span>
                                                @endif
                                                @if ($fee->is_onetime_fee)
                                                    <span class="badge badge-warning badge-xs">One-time</span>
                                                @endif
                                                <span class="badge badge-primary badge-xs">Installment</span>
                                            </div>
                                        </div>
                                    @endforeach

                                    <!-- Mobile Total -->
                                    <div class="bg-blue-100 rounded-lg p-4 border-2 border-blue-300">
                                        <div class="flex items-center justify-between">
                                            <span class="font-bold text-blue-800">Installment Total:</span>
                                            <span class="font-bold text-primary text-2xl">
                                                ₱{{ number_format($installmentFees->sum('amount'), 2) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Grand Total -->
                        <div
                            class="mt-6 p-6 bg-gradient-to-r from-accent/10 to-accent/5 rounded-lg border-2 border-accent">
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">Grand Total</h3>
                                    <p class="text-sm text-gray-600">All fees combined</p>
                                </div>
                                <div class="text-center sm:text-right">
                                    <p class="text-3xl font-bold text-accent">
                                        ₱{{ number_format($strand->tuitionFees->sum('amount'), 2) }}
                                    </p>
                                    <div class="text-sm text-gray-600 mt-1">
                                        @if ($fullPaymentFees->count() > 0)
                                            <span class="text-success font-medium">
                                                ₱{{ number_format($fullPaymentFees->sum('amount'), 2) }}
                                            </span>
                                        @endif
                                        @if ($fullPaymentFees->count() > 0 && $installmentFees->count() > 0)
                                            <span class="mx-1">+</span>
                                        @endif
                                        @if ($installmentFees->count() > 0)
                                            <span class="text-primary font-medium">
                                                ₱{{ number_format($installmentFees->sum('amount'), 2) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Agreement Info -->
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Full Payment Info -->
                            <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                                <h4 class="font-semibold text-green-900 mb-2 flex items-center gap-2">
                                    <i class="fi fi-rr-money-bill-wave"></i>
                                    Full Payment
                                </h4>
                                <div class="text-sm text-green-800 space-y-1">
                                    <p>• Pay the entire amount at once</p>
                                    <p>• May include discounts or benefits</p>
                                    <p>• Complete payment upon enrollment</p>
                                </div>
                            </div>

                            <!-- Installment Info -->
                            <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                                <h4 class="font-semibold text-blue-900 mb-2 flex items-center gap-2">
                                    <i class="fi fi-rr-calendar"></i>
                                    Installment
                                </h4>
                                <div class="text-sm text-blue-800 space-y-1">
                                    <p>• Pay in multiple installments</p>
                                    <p>• Spread payments throughout the year</p>
                                    <p>• Flexible payment schedule</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Section -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-semibold text-gray-800">Payment Options</h2>
                            @if ($strand && $strand->tuitionFees->count() > 0)
                                <div class="text-right">
                                    <p class="text-sm text-gray-600">Select Payment Type</p>
                                    <div class="flex gap-2 mt-1">
                                        @if ($fullPaymentFees->count() > 0)
                                            <span class="badge badge-success">
                                                Full: ₱{{ number_format($fullPaymentFees->sum('amount'), 2) }}
                                            </span>
                                        @endif
                                        @if ($installmentFees->count() > 0)
                                            <span class="badge badge-primary">
                                                Inst: ₱{{ number_format($installmentFees->sum('amount'), 2) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>




                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($paymentAccounts as $account)
                                <div class="p-6 bg-gray-50 rounded-lg border hover:border-accent transition-colors">
                                    <div class="flex items-start justify-between mb-4">
                                        <div>
                                            <h3 class="font-medium text-gray-900">{{ $account->provider }}</h3>
                                            <p class="text-sm text-gray-600">{{ $account->account_name }}</p>
                                        </div>
                                        <button onclick="showPaymentModal('{{ $account->id }}')"
                                            class="btn btn-accent btn-sm">
                                            <i class="fi fi-rr-plus"></i>
                                        </button>
                                    </div>

                                    <div class="space-y-2">
                                        <p class="text-sm">
                                            <span class="text-gray-500">Account Number:</span>
                                            <span class="font-medium">{{ $account->account_number }}</span>
                                        </p>
                                        @if ($account->qr_image_path)
                                            <button
                                                onclick="showQRModal('{{ Storage::url($account->qr_image_path) }}')"
                                                class="btn btn-ghost btn-sm gap-2">
                                                <i class="fi fi-rr-qrcode"></i>
                                                View QR Code
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Payment Modal -->
                <dialog id="payment_modal" class="modal">
                    <div class="modal-box max-w-lg">
                        <h3 class="font-bold text-lg mb-4">Submit Payment</h3>
                        <form action="{{ route('student.payments.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="payment_account_id" id="payment_account_id">
                            <input type="hidden" name="enrollment_form_id" value="{{ $enrollment->id }}">

                            <!-- Payment Type Selection -->
                            <div class="form-control mb-4">
                                <label class="label">
                                    <span class="label-text font-semibold">Select Payment Type</span>
                                </label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @if ($fullPaymentFees->count() > 0)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="payment_type" value="full_payment"
                                                class="peer sr-only" required
                                                data-amount="{{ $fullPaymentFees->sum('amount') }}">
                                            <div
                                                class="p-4 border-2 border-gray-200 rounded-lg peer-checked:border-success peer-checked:bg-green-50 transition-all">
                                                <div class="flex items-center gap-2 mb-2">
                                                    <i class="fi fi-rr-money-bill-wave text-success"></i>
                                                    <span class="font-semibold text-sm">Full Payment</span>
                                                </div>
                                                <p class="text-xl font-bold text-success">
                                                    ₱{{ number_format($fullPaymentFees->sum('amount'), 2) }}
                                                </p>
                                                <p class="text-xs text-gray-600 mt-1">Pay all at once</p>
                                            </div>
                                        </label>
                                    @endif

                                    @if ($installmentFees->count() > 0)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="payment_type" value="installment"
                                                class="peer sr-only" required
                                                data-amount="{{ $installmentFees->sum('amount') }}">
                                            <div
                                                class="p-4 border-2 border-gray-200 rounded-lg peer-checked:border-primary peer-checked:bg-blue-50 transition-all">
                                                <div class="flex items-center gap-2 mb-2">
                                                    <i class="fi fi-rr-calendar text-primary"></i>
                                                    <span class="font-semibold text-sm">Installment</span>
                                                </div>
                                                <p class="text-xl font-bold text-primary">
                                                    ₱{{ number_format($installmentFees->sum('amount'), 2) }}
                                                </p>
                                                <p class="text-xs text-gray-600 mt-1">Pay in parts</p>
                                            </div>
                                        </label>
                                    @endif
                                </div>
                            </div>

                            <!-- Amount (Auto-filled based on selection) -->
                            <div class="form-control mb-4">
                                <label class="label">
                                    <span class="label-text">Amount to Pay</span>
                                    <span class="label-text-alt text-accent font-semibold" id="selected_amount">
                                        Select payment type
                                    </span>
                                </label>
                                <input type="number" name="amount" id="amount_input" class="input input-bordered"
                                    required min="0" step="0.01" readonly>
                            </div>

                            <div class="form-control mb-4">
                                <label class="label">
                                    <span class="label-text">Payment Method</span>
                                </label>
                                <select name="payment_method" class="select select-bordered" required>
                                    <option value="">Select Method</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="gcash">GCash</option>
                                    <option value="maya">Maya</option>
                                    <option value="cash">Cash</option>
                                </select>
                            </div>

                            <div class="form-control mb-4">
                                <label class="label">
                                    <span class="label-text">Payment Proof</span>
                                </label>
                                <input type="file" name="attachment" class="file-input file-input-bordered w-full"
                                    accept="image/*,.pdf" required>
                                <label class="label">
                                    <span class="label-text-alt text-gray-500">Upload receipt or proof of
                                        payment</span>
                                </label>
                            </div>

                            <div class="form-control mb-6">
                                <label class="label">
                                    <span class="label-text">Note (Optional)</span>
                                </label>
                                <textarea name="note" class="textarea textarea-bordered" rows="2"
                                    placeholder="Add any additional notes about this payment"></textarea>
                            </div>

                            <div class="modal-action">
                                <button type="button" onclick="closePaymentModal()"
                                    class="btn btn-ghost">Cancel</button>
                                <button type="submit" class="btn btn-accent">Submit Payment</button>
                            </div>
                        </form>
                    </div>
                    <form method="dialog" class="modal-backdrop">
                        <button>close</button>
                    </form>
                </dialog>

            @endif


        </div>
    </div>


    <!-- QR Code Modal -->
    <dialog id="qr_modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">Scan QR Code</h3>
            <div class="flex justify-center">
                <img id="qr_image" src="" alt="QR Code" class="max-w-[200px]">
            </div>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Close</button>
                </form>
            </div>
        </div>
    </dialog>

    @push('scripts')
        <script>
            function showPaymentModal(accountId) {
                document.getElementById('payment_account_id').value = accountId;
                document.getElementById('payment_modal').showModal();
            }

            function closePaymentModal() {
                document.getElementById('payment_modal').close();
            }

            function showQRModal(qrUrl) {
                document.getElementById('qr_image').src = qrUrl;
                document.getElementById('qr_modal').showModal();
            }

            // Handle payment type selection
            document.addEventListener('DOMContentLoaded', function() {
                const paymentTypeRadios = document.querySelectorAll('input[name="payment_type"]');
                const amountInput = document.getElementById('amount_input');
                const selectedAmountLabel = document.getElementById('selected_amount');

                paymentTypeRadios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        const amount = parseFloat(this.dataset.amount);
                        amountInput.value = amount.toFixed(2);
                        selectedAmountLabel.textContent = '₱' + amount.toFixed(2).replace(
                            /\d(?=(\d{3})+\.)/g, '$&,');
                    });
                });
            });
        </script>
    @endpush
</x-dashboard.student.base>
