<x-dashboard.admin.base>
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Payment Account Details</h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.payment-accounts.index') }}" 
                   class="btn btn-ghost btn-sm">
                    <i class="fi fi-rr-arrow-left"></i>
                    Back
                </a>
                <a href="{{ route('admin.payment-accounts.edit', $paymentAccount) }}" 
                   class="btn btn-accent btn-sm">
                    <i class="fi fi-rr-edit"></i>
                    Edit
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6 space-y-6">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Provider</h3>
                    <p class="mt-1 text-lg">{{ $paymentAccount->provider }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Account Name</h3>
                    <p class="mt-1 text-lg">{{ $paymentAccount->account_name }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Account Number</h3>
                    <p class="mt-1 text-lg">{{ $paymentAccount->account_number }}</p>
                </div>
            </div>

            @if($paymentAccount->qr_image_path)
                <div>
                    <h3 class="text-sm font-medium text-gray-500 mb-2">QR Code</h3>
                    <img src="{{ Storage::url($paymentAccount->qr_image_path) }}" 
                         alt="QR Code"
                         class="w-48 h-48 object-cover rounded">
                </div>
            @endif

            <div class="pt-4 border-t">
                <p class="text-sm text-gray-500">
                    Created {{ $paymentAccount->created_at->diffForHumans() }}
                    @if($paymentAccount->updated_at->ne($paymentAccount->created_at))
                        • Updated {{ $paymentAccount->updated_at->diffForHumans() }}
                    @endif
                </p>
            </div>
        </div>
    </div>
</x-dashboard.admin.base>