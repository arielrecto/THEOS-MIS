@php
    use App\Enums\PaymentStatus;

    $pending = $summary[PaymentStatus::PENDING->value];
    $approved = $summary[PaymentStatus::APPROVED->value];

    // Presentation for each status value; the values themselves live in PaymentStatus.
    $statusStyles = [
        PaymentStatus::PENDING->value => 'bg-amber-100 text-amber-700',
        PaymentStatus::APPROVED->value => 'bg-emerald-100 text-emerald-700',
        PaymentStatus::REJECTED->value => 'bg-red-100 text-red-700',
    ];
    $statusDots = [
        PaymentStatus::PENDING->value => 'bg-amber-500',
        PaymentStatus::APPROVED->value => 'bg-emerald-500',
        PaymentStatus::REJECTED->value => 'bg-red-500',
    ];
@endphp

<x-dashboard.student.base>
    <div class="overflow-hidden relative px-4 pt-6 pb-28 bg-center bg-no-repeat bg-cover rounded-2xl sm:px-6 sm:pt-8 sm:pb-36 lg:px-10"
        style="background-image: url('{{ asset('bg3.JPEG') }}')">

        <!-- Summary cards -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 lg:gap-6">
            <!-- Total Paid -->
            <div class="p-5 rounded-2xl border shadow-lg backdrop-blur-sm border-white/70 bg-blue-50/90">
                <div class="flex gap-3 items-center">
                    <span class="flex justify-center items-center w-9 h-9 text-blue-600 bg-blue-100 rounded-lg">
                        <i class="flex fi fi-rr-credit-card"></i>
                    </span>
                    <span class="font-medium text-blue-700">Total Paid</span>
                </div>
                <p class="mt-3 text-3xl font-bold tracking-tight break-words text-slate-800 lg:text-4xl">
                    ₱{{ number_format($totalPaid, 2) }}
                </p>
                <p class="mt-2 text-sm text-blue-600">+{{ $approved['count'] }} Completed</p>
            </div>

            <!-- Pending -->
            <div class="p-5 rounded-2xl border shadow-lg backdrop-blur-sm border-white/70 bg-amber-50/90">
                <div class="flex gap-3 items-center">
                    <span class="flex justify-center items-center w-9 h-9 text-amber-600 bg-amber-100 rounded-lg">
                        <i class="flex fi fi-rr-hourglass-end"></i>
                    </span>
                    <span class="font-medium text-amber-700">Pending</span>
                </div>
                <p class="mt-3 text-3xl font-bold tracking-tight break-words text-slate-800 lg:text-4xl">
                    ₱{{ number_format($pending['total'], 2) }}
                </p>
                <p class="mt-2 text-sm text-amber-700">
                    {{ $pending['count'] }} {{ Str::plural('Payment', $pending['count']) }} Pending
                </p>
            </div>

            <!-- Completed -->
            <div class="p-5 rounded-2xl border shadow-lg backdrop-blur-sm border-white/70 bg-emerald-50/90">
                <div class="flex gap-3 items-center">
                    <span class="flex justify-center items-center w-9 h-9 text-emerald-600 bg-emerald-100 rounded-lg">
                        <i class="flex fi fi-rr-shield-check"></i>
                    </span>
                    <span class="font-medium text-emerald-700">Completed</span>
                </div>
                <p class="mt-3 text-3xl font-bold tracking-tight break-words text-slate-800 lg:text-4xl">
                    ₱{{ number_format($approved['total'], 2) }}
                </p>
                <p class="mt-2 text-sm text-emerald-700">
                    {{ $approved['count'] }} {{ Str::plural('Payment', $approved['count']) }} Approved
                </p>
            </div>
        </div>

        <!-- Payment History -->
        <div class="mt-6 rounded-2xl border shadow-xl backdrop-blur-sm lg:mt-8 border-white/70 bg-white/95">
            <div class="flex flex-wrap gap-3 justify-between items-center px-4 pt-5 pb-4 sm:px-6">
                <h2 class="text-xl font-semibold text-slate-800 sm:text-2xl">Payment History</h2>

                <div class="flex gap-2 items-center">
                    <!-- Filter -->
                    <details class="dropdown dropdown-end">
                        <summary
                            class="gap-1.5 h-8 min-h-0 font-medium normal-case bg-white rounded-full border-slate-300 btn btn-sm btn-outline text-slate-700 hover:bg-slate-100 hover:text-slate-800 hover:border-slate-300">
                            <i class="flex fi fi-rr-filter"></i>
                            {{ $status ? PaymentStatus::from($status)->label() : 'Filter' }}
                        </summary>
                        <ul class="z-20 p-2 mt-2 w-40 bg-white rounded-xl shadow-lg dropdown-content menu">
                            <li>
                                <a href="{{ route('student.payments.index') }}" @class(['active' => !$status])>All</a>
                            </li>
                            @foreach (PaymentStatus::cases() as $case)
                                <li>
                                    <a href="{{ route('student.payments.index', ['status' => $case->value]) }}"
                                        @class(['active' => $status === $case->value])>{{ $case->label() }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </details>

                    <!-- Export -->
                    <a href="{{ route('student.payments.export', array_filter(['status' => $status])) }}"
                        class="gap-1.5 h-8 min-h-0 font-medium normal-case bg-white rounded-full border-slate-300 btn btn-sm btn-outline text-slate-700 hover:bg-slate-100 hover:text-slate-800 hover:border-slate-300">
                        <i class="flex fi fi-rr-download"></i>
                        Export
                    </a>
                </div>
            </div>

            <!-- Mobile: cards -->
            <div class="border-t divide-y md:hidden border-slate-100 divide-slate-100">
                @forelse ($payments as $payment)
                    <article class="flex flex-col gap-3 px-4 py-4">
                        <div class="flex gap-3 justify-between items-start">
                            <div class="min-w-0">
                                <p class="text-lg font-semibold text-slate-800">₱{{ number_format($payment->amount, 2) }}</p>
                                <p class="text-xs text-slate-500">{{ $payment->created_at->format('M d, Y') }}</p>
                            </div>
                            <span @class([
                                'inline-flex shrink-0 items-center gap-1.5 rounded-full px-3 py-1 text-xs font-medium',
                                $statusStyles[$payment->status] ?? 'bg-slate-100 text-slate-700',
                            ])>
                                <span @class(['h-1.5 w-1.5 rounded-full', $statusDots[$payment->status] ?? 'bg-slate-500'])></span>
                                {{ PaymentStatus::tryFrom($payment->status)?->label() ?? ucfirst($payment->status) }}
                            </span>
                        </div>

                        <div class="flex gap-3 justify-between items-center">
                            <div class="flex gap-2 items-center min-w-0">
                                <span class="flex justify-center items-center w-8 h-8 text-xs font-bold text-blue-600 bg-blue-50 rounded-full shrink-0">
                                    {{ strtoupper(substr($payment->payment_method, 0, 1)) }}
                                </span>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium truncate text-slate-700">{{ $payment->paymentAccount?->provider ?? ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
                                    <p class="text-xs truncate text-slate-500">{{ $payment->paymentAccount?->account_number }}</p>
                                </div>
                            </div>
                            <button type="button" onclick="payment_details_modal_{{ $payment->id }}.showModal()"
                                class="gap-1.5 h-8 min-h-0 font-medium normal-case rounded-full border-slate-300 btn btn-sm btn-outline text-slate-700 shrink-0 hover:bg-slate-100 hover:text-slate-800 hover:border-slate-300"
                                aria-label="View payment details">
                                <i class="flex fi fi-rr-eye"></i>
                                View
                            </button>
                        </div>
                    </article>
                @empty
                    <div class="flex flex-col items-center px-4 py-10 text-slate-500">
                        <i class="mb-2 text-3xl fi fi-rr-credit-card"></i>
                        <p>No payment history found</p>
                    </div>
                @endforelse
            </div>

            <!-- Desktop / Tablet: table -->
            <div class="hidden overflow-x-auto md:block">
                <table class="table w-full">
                    <thead>
                        <tr class="text-sm border-y border-slate-100 bg-slate-50/80 text-slate-600">
                            <th class="pl-6">Date</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Account</th>
                            <th>Status</th>
                            <th class="pr-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $payment)
                            <tr class="border-slate-100">
                                <td class="pl-6 whitespace-nowrap text-slate-700">{{ $payment->created_at->format('M d, Y') }}</td>
                                <td class="font-medium whitespace-nowrap text-slate-800">₱{{ number_format($payment->amount, 2) }}</td>
                                <td>
                                    <div class="flex gap-2 items-center">
                                        <span class="flex justify-center items-center w-7 h-7 text-xs font-bold text-blue-600 bg-blue-50 rounded-full shrink-0">
                                            {{ strtoupper(substr($payment->payment_method, 0, 1)) }}
                                        </span>
                                        <span class="text-slate-700">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex flex-col">
                                        <span class="font-medium text-slate-700">{{ $payment->paymentAccount?->provider }}</span>
                                        <span class="text-sm text-slate-500">{{ $payment->paymentAccount?->account_number }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span @class([
                                        'inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-medium',
                                        $statusStyles[$payment->status] ?? 'bg-slate-100 text-slate-700',
                                    ])>
                                        {{ PaymentStatus::tryFrom($payment->status)?->label() ?? ucfirst($payment->status) }}
                                        <span @class(['h-1.5 w-1.5 rounded-full', $statusDots[$payment->status] ?? 'bg-slate-500'])></span>
                                    </span>
                                </td>
                                <td class="pr-6 text-right">
                                    <button type="button" onclick="payment_details_modal_{{ $payment->id }}.showModal()"
                                        class="gap-1.5 h-8 min-h-0 font-medium normal-case rounded-full border-slate-300 btn btn-sm btn-outline text-slate-700 hover:bg-slate-100 hover:text-slate-800 hover:border-slate-300"
                                        aria-label="View payment details">
                                        <i class="flex fi fi-rr-eye"></i>
                                        View
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-10 text-center">
                                    <div class="flex flex-col justify-center items-center text-slate-500">
                                        <i class="mb-2 text-3xl fi fi-rr-credit-card"></i>
                                        <p>No payment history found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($payments->hasPages())
                <div class="px-4 py-4 border-t sm:px-6 border-slate-100">
                    {{ $payments->links() }}
                </div>
            @endif
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
                    @if ($payment->note)
                        <div class="border rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <i class="fi fi-rr-comment-alt text-xl text-gray-400 mt-1"></i>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-600 mb-2">Notes</p>
                                    <p class="text-gray-900 whitespace-pre-wrap">{{ $payment->note }}</p>
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
