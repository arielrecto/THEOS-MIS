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

        <!-- Payments: desktop table + mobile stacked list -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <!-- Mobile: stacked card list (visible on xs, hidden on sm+) -->
            <div class="block sm:hidden px-3 py-3 space-y-3">
                @forelse($payments as $payment)
                    <div class="bg-white border rounded-lg shadow-sm p-3">
                        <div class="flex items-start gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="min-w-0">
                                        <div class="text-sm font-semibold text-gray-800 break-words">
                                            {{ $payment->user->name }}
                                        </div>
                                        <div class="text-2xs text-gray-500 mt-1 break-words">
                                            {{ $payment->created_at->format('M d, Y') }}
                                        </div>
                                    </div>

                                    <div class="text-right flex-shrink-0">
                                        <div class="text-sm font-medium">₱{{ number_format($payment->amount, 2) }}</div>
                                        <div class="text-2xs text-gray-500 mt-1">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</div>
                                    </div>
                                </div>

                                <div class="mt-2 text-xs text-gray-600 break-words">
                                    <div class="flex items-center justify-between gap-2">
                                        <div class="min-w-0 pr-2">
                                            <div class="font-medium">{{ $payment->paymentAccount->provider }}</div>
                                            <div class="text-2xs text-gray-500">{{ $payment->paymentAccount->account_number }}</div>
                                        </div>

                                        <div class="flex-shrink-0 ml-2">
                                            <span @class([
                                                'inline-flex items-center px-2 py-0.5 rounded text-xs font-medium',
                                                'bg-yellow-100 text-yellow-800' => $payment->status === 'pending',
                                                'bg-green-100 text-green-800' => $payment->status === 'approved',
                                                'bg-red-100 text-red-800' => $payment->status === 'rejected',
                                            ])>
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 grid grid-cols-3 gap-2">
                            <a href="{{ route('admin.payments.show', $payment) }}"
                               class="btn btn-ghost btn-sm w-full text-xs flex items-center justify-center gap-2">
                                <i class="fi fi-rr-eye"></i>
                                View
                            </a>

                            {{-- @if(method_exists($payment, 'canEdit') ? $payment->canEdit() : true)
                                <a href="{{ route('admin.payments.edit', $payment) ?? '#' }}"
                                   class="btn btn-ghost btn-sm w-full text-xs flex items-center justify-center gap-2">
                                    <i class="fi fi-rr-edit"></i>
                                    Edit
                                </a>
                            @else
                                <div></div>
                            @endif --}}

                            {{-- <form action="{{ route('admin.payments.destroy', $payment) ?? '#' }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this payment?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-ghost btn-sm text-error w-full text-xs flex items-center justify-center gap-2">
                                    <i class="fi fi-rr-trash"></i>
                                    Delete
                                </button>
                            </form> --}}
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg shadow-sm p-4 text-center text-gray-500 border">
                        <i class="fi fi-rr-credit-card text-2xl mb-2"></i>
                        <p class="text-sm">No payments found</p>
                    </div>
                @endforelse
            </div>

            <!-- Desktop / Tablet: table (hidden on xs) -->
            <div class="hidden sm:block overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Student</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Account</th>
                            <th>Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td class="align-middle">{{ $payment->created_at->format('M d, Y') }}</td>
                                <td class="align-middle">{{ $payment->user->name }}</td>
                                <td class="align-middle font-medium">₱{{ number_format($payment->amount, 2) }}</td>
                                <td class="align-middle">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                <td class="align-middle">
                                    <div class="flex flex-col">
                                        <span class="font-medium">{{ $payment->paymentAccount->provider }}</span>
                                        <span class="text-xs text-gray-500">{{ $payment->paymentAccount->account_number }}</span>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <span @class([
                                        'badge',
                                        'badge-warning' => $payment->status === 'pending',
                                        'badge-success' => $payment->status === 'approved',
                                        'badge-error' => $payment->status === 'rejected'
                                    ])>
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td class="align-middle text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('admin.payments.show', $payment) }}"
                                           class="btn btn-ghost btn-sm" title="View">
                                            <i class="fi fi-rr-eye"></i>
                                        </a>
                                    </div>
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
