<x-dashboard.admin.base>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Payment Accounts</h2>
            <a href="{{ route('admin.payment-accounts.create') }}" 
               class="btn btn-accent btn-sm gap-2">
                <i class="fi fi-rr-plus"></i>
                Add Account
            </a>
        </div>

        <!-- Accounts List -->
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>Provider</th>
                        <th>Account Name</th>
                        <th>Account Number</th>
                        <th>QR Code</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($accounts as $account)
                        <tr>
                            <td>{{ $account->provider }}</td>
                            <td>{{ $account->account_name }}</td>
                            <td>{{ $account->account_number }}</td>
                            <td>
                                @if($account->qr_image_path)
                                    <img src="{{ Storage::url($account->qr_image_path) }}" 
                                         alt="QR Code" 
                                         class="w-12 h-12 object-cover rounded">
                                @else
                                    <span class="text-gray-400">No QR</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.payment-accounts.show', $account) }}" 
                                       class="btn btn-ghost btn-xs">
                                        <i class="fi fi-rr-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.payment-accounts.edit', $account) }}" 
                                       class="btn btn-ghost btn-xs">
                                        <i class="fi fi-rr-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.payment-accounts.destroy', $account) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this account?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-ghost btn-xs text-error">
                                            <i class="fi fi-rr-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <i class="fi fi-rr-credit-card text-3xl mb-2"></i>
                                    <p>No payment accounts found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $accounts->links() }}
        </div>
    </div>
</x-dashboard.admin.base>