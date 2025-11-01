<x-dashboard.admin.base>
    <div class="max-w-4xl mx-auto">
        <!-- Header with Back Button -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Payment Details</h2>
            <a href="{{ route('admin.payments.index') }}"
               class="btn btn-ghost btn-sm gap-2">
                <i class="fi fi-rr-arrow-left"></i>
                Back to List
            </a>
        </div>

        <!-- Status Banner -->
        <div class="mb-6 p-4 rounded-lg {{
            $payment->status === 'pending' ? 'bg-yellow-50 border border-yellow-200' :
            ($payment->status === 'approved' ? 'bg-green-50 border border-green-200' :
            'bg-red-50 border border-red-200')
        }}">
            <div class="flex items-center gap-3">
                <i class="fi {{
                    $payment->status === 'pending' ? 'fi-rr-clock text-yellow-600' :
                    ($payment->status === 'approved' ? 'fi-rr-check text-green-600' :
                    'fi-rr-cross text-red-600')
                }}"></i>
                <div>
                    <p class="font-medium {{
                        $payment->status === 'pending' ? 'text-yellow-800' :
                        ($payment->status === 'approved' ? 'text-green-800' :
                        'text-red-800')
                    }}">
                        Payment {{ ucfirst($payment->status) }}
                    </p>
                    @if($payment->remarks)
                        <p class="text-sm text-gray-600 mt-1">{{ $payment->remarks }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Student Information -->
                    <div>
                        <h3 class="font-medium text-gray-700 mb-4">Student Information</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-600">Name</p>
                                <p class="font-medium">{{ $payment->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Student ID</p>
                                <p class="font-medium">{{ $payment->user->student_id ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Details -->
                    <div>
                        <h3 class="font-medium text-gray-700 mb-4">Payment Details</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-600">Amount</p>
                                <p class="font-medium">₱{{ number_format($payment->amount, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Payment Method</p>
                                <p class="font-medium">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Date Submitted</p>
                                <p class="font-medium">{{ $payment->created_at->format('F j, Y g:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Account -->
                    <div class="col-span-full">
                        <h3 class="font-medium text-gray-700 mb-4">Payment Account</h3>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">Provider</p>
                                    <p class="font-medium">{{ $payment->paymentAccount->provider }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Account Number</p>
                                    <p class="font-medium">{{ $payment->paymentAccount->account_number }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Account Name</p>
                                    <p class="font-medium">{{ $payment->paymentAccount->account_name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Proof -->
                    <div class="col-span-full">
                        <h3 class="font-medium text-gray-700 mb-4">Payment Proof</h3>
                        <img src="{{ Storage::url($payment->attachment) }}"
                             alt="Payment Proof"
                             class="max-h-96 rounded-lg border">
                    </div>
                </div>

                <!-- Action Buttons -->
                @if($payment->status === 'pending')
                    <div class="mt-8 pt-6 border-t flex justify-end gap-4">
                        <form action="{{ route('admin.payments.update-status', $payment) }}"
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to reject this payment?')">
                            @csrf
                            <input type="hidden" name="status" value="rejected">
                            <input type="text"
                                   name="remarks"
                                   placeholder="Enter rejection reason"
                                   class="input input-bordered mr-2">
                            <button type="submit" class="btn btn-error">
                                <i class="fi fi-rr-cross"></i>
                                Reject
                            </button>
                        </form>

                        <form action="{{ route('admin.payments.update-status', $payment) }}"
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to approve this payment?')">
                            @csrf
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="btn btn-success">
                                <i class="fi fi-rr-check"></i>
                                Approve
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-dashboard.admin.base>
