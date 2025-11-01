<x-dashboard.student.base>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="mb-6">
                <a href="{{ route('student.enrollment.index') }}"
                   class="btn btn-ghost btn-sm gap-2">
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
                        <span class="badge {{
                            $enrollment->status === 'pending' ? 'badge-warning' :
                            ($enrollment->status === 'enrolled' ? 'badge-success' : 'badge-error')
                        }}">
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
                                            <a href="{{ Storage::url($attachment->file_dir) }}"
                                               target="_blank"
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

            <!-- Payment Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Payment Options</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($paymentAccounts as $account)
                            <div class="p-6 bg-gray-50 rounded-lg border hover:border-accent transition-colors">
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <h3 class="font-medium text-gray-900">{{ $account->provider }}</h3>
                                        <p class="text-sm text-gray-600">{{ $account->account_name }}</p>
                                    </div>
                                    <button onclick="showPaymentModal('{{ $account->id }}')"
                                            class="btn btn-ghost btn-sm">
                                        <i class="fi fi-rr-plus"></i>
                                    </button>
                                </div>

                                <div class="space-y-2">
                                    <p class="text-sm">
                                        <span class="text-gray-500">Account Number:</span>
                                        <span class="font-medium">{{ $account->account_number }}</span>
                                    </p>
                                    @if($account->qr_image_path)
                                        <button onclick="showQRModal('{{ Storage::url($account->qr_image_path) }}')"
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
        </div>
    </div>

    <!-- Payment Modal -->
    <dialog id="payment_modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">Submit Payment</h3>
            <form action="{{ route('student.payments.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="payment_account_id" id="payment_account_id">

                <div class="form-control mb-4">
                    <label class="label">Amount</label>
                    <input type="number"
                           name="amount"
                           class="input input-bordered"
                           required
                           min="0"
                           step="0.01">
                </div>

                <div class="form-control mb-4">
                    <label class="label">Payment Method</label>
                    <select name="payment_method" class="select select-bordered" required>
                        <option value="">Select Method</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="gcash">GCash</option>
                        <option value="maya">Maya</option>
                    </select>
                </div>

                <div class="form-control mb-4">
                    <label class="label">Payment Proof</label>
                    <input type="file"
                           name="attachment"
                           class="file-input file-input-bordered w-full"
                           accept="image/*,.pdf"
                           required>
                </div>

                <div class="form-control mb-6">
                    <label class="label">Note (Optional)</label>
                    <textarea name="note"
                            class="textarea textarea-bordered"
                            rows="2"></textarea>
                </div>

                <div class="modal-action">
                    <button type="button"
                            onclick="closePaymentModal()"
                            class="btn btn-ghost">Cancel</button>
                    <button type="submit" class="btn btn-accent">Submit Payment</button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

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
    </script>
    @endpush
</x-dashboard.student.base>
