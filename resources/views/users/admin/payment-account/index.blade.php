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

        <!-- Mobile: stacked list (visible on small screens) -->
        <div class="space-y-3 block sm:hidden">
            @forelse($accounts as $account)
                <div class="bg-white rounded-lg shadow p-3 border flex flex-col gap-2">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            @if($account->qr_image_path)
                                <img src="{{ Storage::url($account->qr_image_path) }}"
                                     alt="QR Code"
                                     class="w-14 h-14 object-cover rounded">
                            @else
                                <div class="w-14 h-14 bg-gray-100 rounded flex items-center justify-center text-gray-400">
                                    <i class="fi fi-rr-credit-card"></i>
                                </div>
                            @endif
                        </div>

                        <div class="min-w-0 flex-1">
                            <div class="flex items-center justify-between gap-2">
                                <h3 class="text-sm font-semibold text-gray-800 truncate">
                                    {{ $account->provider }}
                                </h3>
                                <div class="text-xs text-gray-500">
                                    @if($account->is_active ?? false)
                                        <span class="inline-block px-2 py-0.5 rounded bg-green-100 text-green-700">Active</span>
                                    @endif
                                </div>
                            </div>

                            <p class="text-xs text-gray-600 mt-1 truncate">
                                {{ $account->account_name }}
                            </p>

                            <p class="text-xs text-gray-500 mt-1 break-words">
                                <span class="font-mono text-sm">{{ $account->account_number }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2 mt-2">
                        <a href="{{ route('admin.payment-accounts.show', $account) }}"
                           class="btn btn-ghost btn-sm flex-1 min-w-[110px]">
                            <i class="fi fi-rr-eye mr-2"></i>
                            View
                        </a>

                        <a href="{{ route('admin.payment-accounts.edit', $account) }}"
                           class="btn btn-ghost btn-sm flex-1 min-w-[110px]">
                            <i class="fi fi-rr-edit mr-2"></i>
                            Edit
                        </a>

                        <form action="{{ route('admin.payment-accounts.destroy', $account) }}"
                              method="POST"
                              class="flex-1 min-w-[110px]"
                              onsubmit="return confirm('Are you sure you want to delete this account?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-ghost btn-sm text-error w-full">
                                <i class="fi fi-rr-trash mr-2"></i>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow p-4 text-center text-gray-500 border">
                    <i class="fi fi-rr-credit-card text-2xl mb-2"></i>
                    <p class="text-sm">No payment accounts found</p>
                </div>
            @endforelse
        </div>

        <!-- Desktop / Tablet: table (hidden on xs) -->
        <div class="hidden sm:block overflow-x-auto bg-white rounded-lg shadow">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>Provider</th>
                        <th>Account Name</th>
                        <th>Account Number</th>
                        <th>QR Code</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($accounts as $account)
                        <tr>
                            <td class="align-middle">{{ $account->provider }}</td>
                            <td class="align-middle">{{ $account->account_name }}</td>
                            <td class="align-middle font-mono">{{ $account->account_number }}</td>
                            <td class="align-middle">
                                @if($account->qr_image_path)
                                    <img src="{{ Storage::url($account->qr_image_path) }}"
                                         alt="QR Code"
                                         class="w-12 h-12 object-cover rounded">
                                @else
                                    <span class="text-gray-400">No QR</span>
                                @endif
                            </td>
                            <td class="align-middle text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.payment-accounts.show', $account) }}"
                                       class="btn btn-ghost btn-xs" title="View">
                                        <i class="fi fi-rr-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.payment-accounts.edit', $account) }}"
                                       class="btn btn-ghost btn-xs" title="Edit">
                                        <i class="fi fi-rr-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.payment-accounts.destroy', $account) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this account?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-ghost btn-xs text-error" title="Delete">
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

        <!-- Pagination (visible for both views) -->
        <div class="mt-4">
            {{ $accounts->links() }}
        </div>
    </div>
</x-dashboard.admin.base>
