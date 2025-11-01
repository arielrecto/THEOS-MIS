<x-dashboard.admin.base>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Payment Management</h2>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-gray-100 rounded-lg">
                        <i class="fi fi-rr-money-check text-2xl text-gray-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Payments</p>
                        <p class="text-2xl font-semibold">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-yellow-50 rounded-lg">
                        <i class="fi fi-rr-clock text-2xl text-yellow-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Pending</p>
                        <p class="text-2xl font-semibold text-yellow-600">{{ $stats['pending'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-green-50 rounded-lg">
                        <i class="fi fi-rr-check text-2xl text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Approved</p>
                        <p class="text-2xl font-semibold text-green-600">{{ $stats['approved'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-red-50 rounded-lg">
                        <i class="fi fi-rr-cross text-2xl text-red-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Rejected</p>
                        <p class="text-2xl font-semibold text-red-600">{{ $stats['rejected'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payments Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Student</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Account</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td>{{ $payment->created_at->format('M d, Y') }}</td>
                                <td>{{ $payment->user->name }}</td>
                                <td class="font-medium">₱{{ number_format($payment->amount, 2) }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                <td>
                                    <div class="flex flex-col">
                                        <span class="font-medium">{{ $payment->paymentAccount->provider }}</span>
                                        <span class="text-xs text-gray-500">{{ $payment->paymentAccount->account_number }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span @class([
                                        'badge',
                                        'badge-warning' => $payment->status === 'pending',
                                        'badge-success' => $payment->status === 'approved',
                                        'badge-error' => $payment->status === 'rejected'
                                    ])>
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.payments.show', $payment) }}"
                                       class="btn btn-ghost btn-sm">
                                        <i class="fi fi-rr-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="flex flex-col items-center justify-center text-gray-500">
                                        <i class="fi fi-rr-credit-card text-3xl mb-2"></i>
                                        <p>No payments found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t">
                {{ $payments->links() }}
            </div>
        </div>
    </div>

    <!-- Payment Details Modal -->
    <dialog id="payment_details_modal" class="modal">
        <div class="modal-box max-w-2xl">
            <h3 class="font-bold text-lg mb-4">Payment Details</h3>
            <div id="payment_details_content" class="space-y-6">
                <!-- Content will be loaded dynamically -->
            </div>

            <!-- Action Buttons for Pending Payments -->
            <div id="payment_actions" class="mt-6 pt-4 border-t hidden">
                <div class="flex justify-between items-center">
                    <button onclick="rejectPayment()" class="btn btn-error btn-sm gap-2">
                        <i class="fi fi-rr-cross"></i>
                        Reject
                    </button>
                    <button onclick="approvePayment()" class="btn btn-success btn-sm gap-2">
                        <i class="fi fi-rr-check"></i>
                        Approve
                    </button>
                </div>
            </div>

            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Close</button>
                </form>
            </div>
        </div>
    </dialog>


</x-dashboard.admin.base>
