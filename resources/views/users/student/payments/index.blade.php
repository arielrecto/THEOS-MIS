<x-dashboard.student.base>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Payment Overview Cards -->
            {{-- <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Total Payments -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-accent/10 rounded-lg">
                            <i class="fi fi-rr-money-check text-2xl text-accent"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Total Paid</p>
                            <p class="text-2xl font-semibold text-gray-900">
                                ₱{{ number_format($totalPaid, 2) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Pending Payments -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-yellow-50 rounded-lg">
                            <i class="fi fi-rr-clock text-2xl text-yellow-600"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Pending Payments</p>
                            <p class="text-2xl font-semibold text-gray-900">
                                {{ $payments->where('status', 'pending')->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Approved Payments -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-green-50 rounded-lg">
                            <i class="fi fi-rr-check text-2xl text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Approved Payments</p>
                            <p class="text-2xl font-semibold text-gray-900">
                                {{ $payments->where('status', 'approved')->count() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- Payment History -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Payment History</h2>

                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                    <th>Account</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->created_at->format('M d, Y') }}</td>
                                        <td class="font-medium">₱{{ number_format($payment->amount, 2) }}</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                        <td>
                                            <div class="flex flex-col">
                                                <span class="font-medium">{{ $payment->paymentAccount->provider }}</span>
                                                <span
                                                    class="text-sm text-gray-500">{{ $payment->paymentAccount->account_number }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span @class([
                                                'badge',
                                                'badge-warning' => $payment->status === 'pending',
                                                'badge-success' => $payment->status === 'approved',
                                                'badge-error' => $payment->status === 'rejected',
                                            ])>
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>

                                        <!-- Actions: view details (opens modal) -->
                                        <td class="text-right">
                                            <button onclick="payment_details_modal_{{ $payment->id }}.showModal()"
                                                type="button" class="btn btn-ghost btn-sm"
                                                aria-label="View payment details">
                                                <i class="fi fi-rr-eye"></i>
                                                <span class="hidden sm:inline ml-2">View</span>
                                            </button>

                                            <!-- Payment Details Modal (DaisyUI) -->
                                            <dialog id="payment_details_modal_{{ $payment->id }}" class="modal">
                                                <form method="dialog" class="modal-box max-w-2xl w-full">
                                                    <h3 id="payment_details_title" class="font-bold text-lg">Payment
                                                        Details</h3>

                                                    <div id="payment_details_content"
                                                        class="mt-4 space-y-4 text-sm text-gray-700">
                                                        <p><strong>Date:</strong>
                                                            {{ $payment->created_at->format('M d, Y h:i A') }}</p>
                                                        <p><strong>Amount:</strong>
                                                            ₱{{ number_format($payment->amount, 2) }}</p>
                                                        <p><strong>Payment Method:</strong>
                                                            {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                                                        </p>
                                                        <p><strong>Account Provider:</strong>
                                                            {{ $payment->paymentAccount->provider }}</p>
                                                        <p><strong>Account Number:</strong>
                                                            {{ $payment->paymentAccount->account_number }}</p>
                                                        <p><strong>Status:</strong>
                                                            {{-- {{ ucfirst($payment->status) }}</p>
                                                        <p><strong>Reference Number:</strong>
                                                            {{ $payment->reference_number ?? 'N/A' }}</p>
                                                        <p><strong>Remarks:</strong>
                                                            {{ $payment->remarks ?? 'N/A' }}</p> --}}

                                                    </div>

                                                    <div class="modal-action">
                                                        <form method="dialog">
                                                        <button class="btn"
                                                            >Close</button>
                                                        </form>
                                                    </div>
                                                </form>
                                            </dialog>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="flex flex-col items-center justify-center text-gray-500">
                                                <i class="fi fi-rr-credit-card text-3xl mb-2"></i>
                                                <p>No payment history found</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>




</x-dashboard.student.base>
