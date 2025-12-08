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
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Payment History</h2>

                    <!-- Mobile: compact cards -->
                    <div class="space-y-4 md:hidden">
                        @forelse($payments as $payment)
                            <article class="bg-white border rounded-lg p-4 shadow-sm">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 rounded-lg bg-accent/10 flex items-center justify-center text-accent">
                                            <i class="fi fi-rr-credit-card text-xl"></i>
                                        </div>
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between gap-2">
                                            <div class="min-w-0">
                                                <p class="text-sm font-semibold text-gray-800 truncate">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
                                                <p class="text-xs text-gray-500 truncate">{{ $payment->created_at->format('M d, Y h:i A') }}</p>
                                            </div>

                                            <div class="text-right">
                                                <p class="text-sm font-semibold text-gray-900">₱{{ number_format($payment->amount, 2) }}</p>
                                                <span @class([
                                                    'inline-flex items-center px-2 py-0.5 rounded text-xs font-medium',
                                                    'bg-yellow-100 text-yellow-800' => $payment->status === 'pending',
                                                    'bg-green-100 text-green-800' => $payment->status === 'approved',
                                                    'bg-red-100 text-red-800' => $payment->status === 'rejected',
                                                ])>{{ ucfirst($payment->status) }}</span>
                                            </div>
                                        </div>

                                        <div class="mt-2 text-xs text-gray-500">
                                            <div class="truncate">{{ $payment->paymentAccount->provider }} • <span class="font-mono">{{ $payment->paymentAccount->account_number }}</span></div>
                                        </div>

                                        <div class="mt-3 flex gap-2">
                                            <button type="button"
                                                    onclick="document.getElementById('payment_details_modal_{{ $payment->id }}').showModal()"
                                                    class="btn btn-sm btn-ghost flex-1 inline-flex items-center justify-center gap-2"
                                                    aria-label="View payment details">
                                                <i class="fi fi-rr-eye"></i>
                                                <span class="text-xs">Details</span>
                                            </button>

                                            @if($payment->receipt_url ?? false)
                                                <a href="{{ $payment->receipt_url }}" target="_blank" rel="noopener" class="btn btn-sm btn-accent inline-flex items-center justify-center gap-2">
                                                    <i class="fi fi-rr-document"></i>
                                                    <span class="text-xs">Receipt</span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal (per payment) -->
                                <dialog id="payment_details_modal_{{ $payment->id }}" class="modal">
                                    <form method="dialog" class="modal-box max-w-lg w-full">
                                        <div class="flex items-start justify-between gap-3">
                                            <h3 class="font-bold text-lg">Payment Details</h3>
                                            <span class="text-xs text-gray-500">{{ $payment->created_at->format('M d, Y h:i A') }}</span>
                                        </div>

                                        <div class="mt-4 grid grid-cols-1 gap-3 text-sm text-gray-700">
                                            <div class="flex items-center justify-between">
                                                <span class="text-gray-500">Amount</span>
                                                <span class="font-medium">₱{{ number_format($payment->amount, 2) }}</span>
                                            </div>

                                            <div class="flex items-center justify-between">
                                                <span class="text-gray-500">Method</span>
                                                <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</span>
                                            </div>

                                            <div class="flex items-center justify-between">
                                                <span class="text-gray-500">Provider</span>
                                                <span class="font-medium">{{ $payment->paymentAccount->provider }}</span>
                                            </div>

                                            <div class="flex items-center justify-between">
                                                <span class="text-gray-500">Account</span>
                                                <div class="flex items-center gap-2">
                                                    <span class="font-mono text-sm">{{ $payment->paymentAccount->account_number }}</span>
                                                    {{-- <button type="button" class="btn btn-ghost btn-xs" onclick="copyAccount('{{ $payment->paymentAccount->account_number }}')" aria-label="Copy account number">Copy</button> --}}
                                                </div>



                                        </div>

                                            <div class="flex items-center justify-between">
                                                <span class="text-gray-500">
                                                    Status</span>

                                                <span @class([
                                                    'inline-flex items-center px-2 py-0.5 rounded text-xs font-medium',
                                                    'bg-yellow-100 text-yellow-800' => $payment->status === 'pending',
                                                    'bg-green-100 text-green-800' => $payment->status === 'approved',
                                                    'bg-red-100 text-red-800' => $payment->status === 'rejected',
                                                ])>{{ ucfirst($payment->status) }}</span>
                                            </div>

                                            @if($payment->notes)
                                                <div>
                                                    <span class="text-gray-500 block mb-1">Notes</span>
                                                    <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $payment->notes }}</p>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="modal-action mt-4">
                                            @if($payment->receipt_url ?? false)
                                                <a href="{{ $payment->receipt_url }}" target="_blank" rel="noopener" class="btn btn-outline">Open Receipt</a>
                                            @endif
                                            <button class="btn">Close</button>
                                        </div>
                                    </form>
                                </dialog>
                            </article>
                        @empty
                            <div class="text-center py-6 text-gray-500">
                                <i class="fi fi-rr-credit-card text-3xl mb-2"></i>
                                <p>No payment history found</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Desktop / Tablet: table -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                    <th>Account</th>
                                    <th>Status</th>
                                    <th class="text-right">Actions</th>
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

                                                'badge-warning' => $payment->status === 'pending',
                                                'badge-success' => $payment->status === 'approved',
                                                'badge-error' => $payment->status === 'rejected',
                                            ])>
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>

                                        <td class="text-right">
                                            <button onclick="document.getElementById('payment_details_modal_{{ $payment->id }}').showModal()"
                                                type="button" class="btn btn-ghost btn-sm" aria-label="View payment details">
                                                <i class="fi fi-rr-eye"></i>
                                                <span class="hidden sm:inline ml-2">View</span>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Desktop modal already exists per payment (re-uses same dialog as mobile) -->
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

                    <!-- Pagination (compact on mobile) -->
                    <div class="mt-6 flex items-center justify-center md:justify-end">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>




</x-dashboard.student.base>

{{-- @push('scripts')
<script>
    function copyAccount(accountNumber) {
        if (!navigator.clipboard) {
            alert('Copy not supported in this browser.');
            return;
        }
        navigator.clipboard.writeText(accountNumber).then(() => {
            // subtle toast - use alert as fallback
            const el = document.createElement('div');
            el.textContent = 'Account number copied';
            el.className = 'fixed bottom-4 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs py-2 px-3 rounded';
            document.body.appendChild(el);
            setTimeout(() => el.remove(), 1800);
        }).catch(() => alert('Failed to copy'));
    }
</script>
@endpush --}}
