<x-dashboard.student.base>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                                        <div
                                            class="w-12 h-12 rounded-lg bg-accent/10 flex items-center justify-center text-accent">
                                            <i class="fi fi-rr-credit-card text-xl"></i>
                                        </div>
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between gap-2">
                                            <div class="min-w-0">
                                                <p class="text-sm font-semibold text-gray-800 truncate">
                                                    {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
                                                <p class="text-xs text-gray-500 truncate">
                                                    {{ $payment->created_at->format('M d, Y h:i A') }}</p>
                                            </div>

                                            <div class="text-right">
                                                <p class="text-sm font-semibold text-gray-900">
                                                    ₱{{ number_format($payment->amount, 2) }}</p>
                                                <span
                                                    @class([
                                                        'inline-flex items-center px-2 py-0.5 rounded text-xs font-medium',
                                                        'bg-yellow-100 text-yellow-800' => $payment->status === 'pending',
                                                        'bg-green-100 text-green-800' => $payment->status === 'approved',
                                                        'bg-red-100 text-red-800' => $payment->status === 'rejected',
                                                    ])>{{ ucfirst($payment->status) }}</span>
                                            </div>
                                        </div>

                                        <div class="mt-2 text-xs text-gray-500">
                                            <div class="truncate">{{ $payment->paymentAccount->provider }} • <span
                                                    class="font-mono">{{ $payment->paymentAccount->account_number }}</span>
                                            </div>
                                        </div>

                                        <div class="mt-3 flex gap-2">
                                            <button type="button"
                                                onclick="payment_details_modal_{{ $payment->id }}.showModal()"
                                                class="btn btn-sm btn-ghost flex-1 inline-flex items-center justify-center gap-2"
                                                aria-label="View payment details">
                                                <i class="fi fi-rr-eye"></i>
                                                <span class="text-xs">Details</span>
                                            </button>

                                            @if ($payment->receipt_url ?? false)
                                                <a href="{{ $payment->receipt_url }}" target="_blank" rel="noopener"
                                                    class="btn btn-sm btn-accent inline-flex items-center justify-center gap-2">
                                                    <i class="fi fi-rr-document"></i>
                                                    <span class="text-xs">Receipt</span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
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
                                                <span
                                                    class="font-medium">{{ $payment->paymentAccount->provider }}</span>
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

                                        <td class="text-right">
                                            <button onclick="payment_details_modal_{{ $payment->id }}.showModal()"
                                                type="button" class="btn btn-ghost btn-sm"
                                                aria-label="View payment details">
                                                <i class="fi fi-rr-eye"></i>
                                                <span class="hidden sm:inline ml-2">View</span>
                                            </button>
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

                    <!-- Pagination (compact on mobile) -->
                    <div class="mt-6 flex items-center justify-center md:justify-end">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Details Modals -->
    @foreach ($payments as $payment)
        <dialog id="payment_details_modal_{{ $payment->id }}" class="modal">
            <div class="modal-box max-w-2xl">
                <!-- Header -->
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>

                <h3 class="font-bold text-xl mb-1">Payment Details</h3>
                <p class="text-sm text-gray-500 mb-6">Transaction ID: #{{ $payment->id }}</p>

                <!-- Status Banner -->
                <div @class([
                    'alert mb-6',
                    'alert-warning' => $payment->status === 'pending',
                    'alert-success' => $payment->status === 'approved',
                    'alert-error' => $payment->status === 'rejected',
                ])>
                    <i class="fi fi-rr-info-circle text-lg"></i>
                    <div>
                        <h4 class="font-semibold">
                            @if ($payment->status === 'pending')
                                Payment Pending Review
                            @elseif($payment->status === 'approved')
                                Payment Approved
                            @else
                                Payment Rejected
                            @endif
                        </h4>
                        <p class="text-sm">
                            @if ($payment->status === 'pending')
                                Your payment is being reviewed by the finance team
                            @elseif($payment->status === 'approved')
                                Your payment has been verified and approved
                            @else
                                Your payment was rejected. Please contact finance for details.
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="space-y-6">
                    <!-- Amount Section -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Payment Amount</p>
                                <p class="text-3xl font-bold text-gray-900 mt-1">
                                    ₱{{ number_format($payment->amount, 2) }}</p>
                            </div>
                            <div class="p-3 bg-accent/10 rounded-lg">
                                <i class="fi fi-rr-money-check text-3xl text-accent"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Details Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Date & Time -->
                        <div class="border rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <i class="fi fi-rr-calendar text-xl text-gray-400 mt-1"></i>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-600 mb-1">Date & Time</p>
                                    <p class="font-semibold text-gray-900">{{ $payment->created_at->format('M d, Y') }}
                                    </p>
                                    <p class="text-sm text-gray-500">{{ $payment->created_at->format('h:i A') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="border rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <i class="fi fi-rr-credit-card text-xl text-gray-400 mt-1"></i>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-600 mb-1">Payment Method</p>
                                    <p class="font-semibold text-gray-900">
                                        {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Provider -->
                        <div class="border rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <i class="fi fi-rr-bank text-xl text-gray-400 mt-1"></i>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-600 mb-1">Provider</p>
                                    <p class="font-semibold text-gray-900">{{ $payment->paymentAccount->provider }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Account Number -->
                        <div class="border rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <i class="fi fi-rr-hashtag text-xl text-gray-400 mt-1"></i>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-600 mb-1">Account Number</p>
                                    <div class="flex items-center gap-2">
                                        <p class="font-mono font-semibold text-gray-900">
                                            {{ $payment->paymentAccount->account_number }}</p>
                                        <button type="button"
                                            onclick="copyToClipboard('{{ $payment->paymentAccount->account_number }}')"
                                            class="btn btn-xs btn-ghost" title="Copy account number">
                                            <i class="fi fi-rr-copy"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes (if available) -->
                    @if ($payment->notes)
                        <div class="border rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <i class="fi fi-rr-comment-alt text-xl text-gray-400 mt-1"></i>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-600 mb-2">Notes</p>
                                    <p class="text-gray-900 whitespace-pre-wrap">{{ $payment->notes }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Receipt (if available) -->
                    @if ($payment->receipt_url ?? false)
                        <div class="border border-accent/20 bg-accent/5 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <i class="fi fi-rr-document text-2xl text-accent"></i>
                                    <div>
                                        <p class="font-semibold text-gray-900">Payment Receipt</p>
                                        <p class="text-sm text-gray-600">View or download your receipt</p>
                                    </div>
                                </div>
                                <a href="{{ $payment->receipt_url }}" target="_blank" rel="noopener"
                                    class="btn btn-accent btn-sm gap-2">
                                    <i class="fi fi-rr-eye"></i>
                                    View Receipt
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Modal Actions -->
                <div class="modal-action mt-6">
                    @if ($payment->receipt_url ?? false)
                        <a href="{{ $payment->receipt_url }}" target="_blank" rel="noopener"
                            class="btn btn-outline gap-2">
                            <i class="fi fi-rr-download"></i>
                            Download Receipt
                        </a>
                    @endif
                    <form method="dialog">
                        <button class="btn btn-primary">Close</button>
                    </form>
                </div>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>
    @endforeach
</x-dashboard.student.base>

@push('scripts')
    <script>
        function copyToClipboard(text) {
            if (!navigator.clipboard) {
                // Fallback for older browsers
                const textarea = document.createElement('textarea');
                textarea.value = text;
                textarea.style.position = 'fixed';
                textarea.style.opacity = '0';
                document.body.appendChild(textarea);
                textarea.select();
                try {
                    document.execCommand('copy');
                    showToast('Account number copied!');
                } catch (err) {
                    showToast('Failed to copy', 'error');
                }
                document.body.removeChild(textarea);
                return;
            }

            navigator.clipboard.writeText(text).then(() => {
                showToast('Account number copied!');
            }).catch(() => {
                showToast('Failed to copy', 'error');
            });
        }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className =
                `alert ${type === 'error' ? 'alert-error' : 'alert-success'} fixed bottom-4 right-4 w-auto max-w-sm shadow-lg z-50 animate-fade-in`;
            toast.innerHTML = `
            <i class="fi fi-rr-${type === 'error' ? 'cross-circle' : 'check-circle'}"></i>
            <span>${message}</span>
        `;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('animate-fade-out');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
    </script>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-out {
            from {
                opacity: 1;
                transform: translateY(0);
            }

            to {
                opacity: 0;
                transform: translateY(10px);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }

        .animate-fade-out {
            animation: fade-out 0.3s ease-out;
        }
    </style>
@endpush
