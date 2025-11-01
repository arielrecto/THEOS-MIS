<x-dashboard.student.base>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Payment Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
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
            </div>

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
                                                <span class="text-sm text-gray-500">{{ $payment->paymentAccount->account_number }}</span>
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
                                            {{-- <button onclick="showPaymentDetails('{{ $payment->id }}')"
                                                    class="btn btn-ghost btn-sm">
                                                <i class="fi fi-rr-eye"></i>
                                            </button> --}}
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

    {{-- <!-- Payment Details Modal -->
    <dialog id="payment_details_modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">Payment Details</h3>
            <div id="payment_details_content" class="space-y-4">
                <!-- Content will be loaded dynamically -->
            </div>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Close</button>
                </form>
            </div>
        </div>
    </dialog> --}}

    {{-- @push('scripts')
    <script>
        async function showPaymentDetails(paymentId) {
            try {
                const response = await fetch(`/student/payments/${paymentId}`);
                const data = await response.json();

                const content = document.getElementById('payment_details_content');
                content.innerHTML = `
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Amount</p>
                            <p class="font-medium">₱${parseFloat(data.amount).toFixed(2)}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <span class="badge ${getStatusClass(data.status)}">${capitalizeFirst(data.status)}</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Payment Method</p>
                            <p class="font-medium">${capitalizeFirst(data.payment_method.replace('_', ' '))}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Date</p>
                            <p class="font-medium">${new Date(data.created_at).toLocaleDateString()}</p>
                        </div>
                    </div>
                    ${data.note ? `
                        <div>
                            <p class="text-sm text-gray-600">Note</p>
                            <p class="font-medium">${data.note}</p>
                        </div>
                    ` : ''}
                    <div>
                        <p class="text-sm text-gray-600 mb-2">Payment Proof</p>
                        <img src="${data.attachment_url}" alt="Payment Proof" class="max-w-full rounded-lg">
                    </div>
                `;

                document.getElementById('payment_details_modal').showModal();
            } catch (error) {
                console.error('Error fetching payment details:', error);
            }
        }

        function getStatusClass(status) {
            return {
                'pending': 'badge-warning',
                'approved': 'badge-success',
                'rejected': 'badge-error'
            }[status] || 'badge-ghost';
        }

        function capitalizeFirst(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    </script>
    @endpush --}}
</x-dashboard.student.base>
