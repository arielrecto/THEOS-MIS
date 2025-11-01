<x-dashboard.admin.base>
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                {{ isset($paymentAccount) ? 'Edit Payment Account' : 'Add Payment Account' }}
            </h2>
            <a href="{{ route('admin.payment-accounts.index') }}" 
               class="btn btn-ghost btn-sm gap-2">
                <i class="fi fi-rr-arrow-left"></i>
                Back
            </a>
        </div>

        <form action="{{ isset($paymentAccount) 
                       ? route('admin.payment-accounts.update', $paymentAccount) 
                       : route('admin.payment-accounts.store') }}" 
              method="POST" 
              enctype="multipart/form-data" 
              class="space-y-6">
            @csrf
            @if(isset($paymentAccount))
                @method('PUT')
            @endif

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Provider</span>
                </label>
                <input type="text" 
                       name="provider"
                       value="{{ old('provider', $paymentAccount->provider ?? '') }}"
                       class="input input-bordered" 
                       required>
                @error('provider')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Account Name</span>
                </label>
                <input type="text" 
                       name="account_name"
                       value="{{ old('account_name', $paymentAccount->account_name ?? '') }}"
                       class="input input-bordered" 
                       required>
                @error('account_name')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">Account Number</span>
                </label>
                <input type="text" 
                       name="account_number"
                       value="{{ old('account_number', $paymentAccount->account_number ?? '') }}"
                       class="input input-bordered" 
                       required>
                @error('account_number')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text">QR Code Image</span>
                </label>
                <input type="file" 
                       name="qr_image"
                       accept="image/*"
                       class="file-input file-input-bordered w-full" 
                       {{ isset($paymentAccount) ? '' : 'required' }}>
                @error('qr_image')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror

                @if(isset($paymentAccount) && $paymentAccount->qr_image_path)
                    <div class="mt-2">
                        <img src="{{ Storage::url($paymentAccount->qr_image_path) }}" 
                             alt="Current QR Code"
                             class="w-32 h-32 object-cover rounded">
                    </div>
                @endif
            </div>

            <button type="submit" class="btn btn-accent w-full">
                {{ isset($paymentAccount) ? 'Update Account' : 'Create Account' }}
            </button>
        </form>
    </div>
</x-dashboard.admin.base>