<x-dashboard.admin.base>
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-3">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Payment Account Details</h2>

            <div class="flex w-full sm:w-auto flex-col sm:flex-row gap-2">
                <a href="{{ route('admin.payment-accounts.index') }}"
                   class="btn btn-ghost btn-sm w-full sm:w-auto inline-flex items-center justify-center">
                    <i class="fi fi-rr-arrow-left mr-2"></i>
                    <span class="text-sm">Back</span>
                </a>
                <a href="{{ route('admin.payment-accounts.edit', $paymentAccount) }}"
                   class="btn btn-accent btn-sm w-full sm:w-auto inline-flex items-center justify-center">
                    <i class="fi fi-rr-edit mr-2"></i>
                    <span class="text-sm">Edit</span>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Provider</h3>
                    <p class="mt-1 text-base sm:text-lg text-gray-800 break-words">{{ $paymentAccount->provider }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500">Account Name</h3>
                    <p class="mt-1 text-base sm:text-lg text-gray-800 break-words">{{ $paymentAccount->account_name }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500">Account Number</h3>
                    <p class="mt-1 text-base sm:text-lg text-gray-800 break-words">{{ $paymentAccount->account_number }}</p>
                </div>

                @if($paymentAccount->qr_image_path)
                    <div class="sm:col-span-1">
                        <h3 class="text-sm font-medium text-gray-500 mb-2">QR Code</h3>
                        <div class="flex justify-center sm:justify-start">
                            <img src="{{ Storage::url($paymentAccount->qr_image_path) }}"
                                 alt="QR Code"
                                 class="w-32 h-32 sm:w-48 sm:h-48 object-cover rounded">
                        </div>
                    </div>
                @endif
            </div>

            <div class="pt-4 border-t">
                <p class="text-xs sm:text-sm text-gray-500 text-center sm:text-left">
                    Created {{ $paymentAccount->created_at->diffForHumans() }}
                    @if($paymentAccount->updated_at->ne($paymentAccount->created_at))
                        • Updated {{ $paymentAccount->updated_at->diffForHumans() }}
                    @endif
                </p>
            </div>
        </div>
    </div>
</x-dashboard.admin.base>
