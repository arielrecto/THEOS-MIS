<x-dashboard.admin.base>
    <div class="container mx-auto p-6">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Tuition Fee Management</h1>
                    <p class="text-gray-600">Manage tuition fee brackets and individual fees</p>
                </div>
                <button onclick="createBracketModal.showModal()" class="btn btn-accent gap-2">
                    <i class="fi fi-rr-plus"></i>
                    New Fee Bracket
                </button>
            </div>
        </div>

        <x-notification-message />

        <!-- Fee Brackets -->
        <div class="space-y-6">
            @forelse($brackets as $bracket)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <!-- Bracket Header -->
                    <div class="p-4 border-b border-gray-200 bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">{{ $bracket->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $bracket->description }}</p>
                                </div>
                                <span class="badge {{ $bracket->is_active ? 'badge-success' : 'badge-ghost' }}">
                                    {{ $bracket->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <div class="flex gap-2">
                                <button onclick="addFeeModal{{ $bracket->id }}.showModal()"
                                    class="btn btn-sm btn-ghost gap-2">
                                    <i class="fi fi-rr-plus"></i>
                                    Add Fee
                                </button>
                                <button onclick="editBracketModal{{ $bracket->id }}.showModal()"
                                    class="btn btn-sm btn-ghost">
                                    <i class="fi fi-rr-edit"></i>
                                </button>
                                <form action="{{ route('admin.tuition-fee-brackets.toggle-status', $bracket->id) }}"
                                    method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                        class="btn btn-sm {{ $bracket->is_active ? 'btn-warning' : 'btn-success' }}">
                                        <i class="fi fi-rr-{{ $bracket->is_active ? 'ban' : 'check' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.tuition-fee-brackets.delete', $bracket->id) }}"
                                    method="POST" onsubmit="return confirm('Delete this bracket and all its fees?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-error btn-ghost">
                                        <i class="fi fi-rr-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Fees List -->
                    <div class="p-4">
                        @if ($bracket->fees->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="table table-zebra">
                                    <thead>
                                        <tr>
                                            <th>Fee Name</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>Payment Type</th>
                                            <th>Payment Agreement</th>
                                            <th>Status</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bracket->fees as $fee)
                                            <tr>
                                                <td class="font-medium">{{ $fee->name }}</td>
                                                <td>
                                                    <span
                                                        class="badge badge-sm badge-outline">{{ $fee->type }}</span>
                                                </td>
                                                <td class="font-semibold">₱{{ number_format($fee->amount, 2) }}</td>
                                                <td>
                                                    @if ($fee->is_monthly)
                                                        <span class="badge badge-info badge-sm">Monthly</span>
                                                    @elseif($fee->is_onetime_fee)
                                                        <span class="badge badge-warning badge-sm">One-time</span>
                                                    @else
                                                        <span class="badge badge-ghost badge-sm">Regular</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($fee->payment_agreement == 'full')
                                                        <span class="badge badge-success badge-sm">Full Payment</span>
                                                    @elseif($fee->payment_agreement == 'installment')
                                                        <span class="badge badge-primary badge-sm">Installment</span>
                                                    @else
                                                        <span class="badge badge-ghost badge-sm">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge badge-sm {{ $fee->is_active ? 'badge-success' : 'badge-ghost' }}">
                                                        {{ $fee->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td class="text-right">
                                                    <div class="flex gap-2 justify-end">
                                                        <button onclick="editFeeModal{{ $fee->id }}.showModal()"
                                                            class="btn btn-xs btn-ghost">
                                                            <i class="fi fi-rr-edit"></i>
                                                        </button>
                                                        <form
                                                            action="{{ route('admin.tuition-fees.toggle-status', $fee->id) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit"
                                                                class="btn btn-xs {{ $fee->is_active ? 'btn-warning' : 'btn-success' }}">
                                                                <i
                                                                    class="fi fi-rr-{{ $fee->is_active ? 'ban' : 'check' }}"></i>
                                                            </button>
                                                        </form>
                                                        <form
                                                            action="{{ route('admin.tuition-fee.destroy', $fee->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Delete this fee?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-xs btn-error btn-ghost">
                                                                <i class="fi fi-rr-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Edit Fee Modal -->
                                            <dialog id="editFeeModal{{ $fee->id }}" class="modal">
                                                <div class="modal-box max-w-2xl">
                                                    <h3 class="font-bold text-lg mb-4">Edit Fee</h3>
                                                    <form action="{{ route('admin.tuition-fee.update', $fee->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <!-- Fee Name -->
                                                            <div class="form-control md:col-span-2">
                                                                <label class="label">
                                                                    <span class="label-text">Fee Name</span>
                                                                </label>
                                                                <input type="text" name="name"
                                                                    value="{{ $fee->name }}"
                                                                    class="input input-bordered" required>
                                                            </div>

                                                            <!-- Type -->
                                                            <div class="form-control">
                                                                <label class="label">
                                                                    <span class="label-text">Type</span>
                                                                </label>
                                                                <select name="type" class="select select-bordered"
                                                                    required>
                                                                    <option value="Tuition"
                                                                        {{ $fee->type == 'Tuition' ? 'selected' : '' }}>
                                                                        Tuition</option>
                                                                    <option value="Miscellaneous"
                                                                        {{ $fee->type == 'Miscellaneous' ? 'selected' : '' }}>
                                                                        Miscellaneous</option>
                                                                    <option value="Other"
                                                                        {{ $fee->type == 'Other' ? 'selected' : '' }}>
                                                                        Other
                                                                    </option>
                                                                </select>
                                                            </div>

                                                            <div class="form-control">
                                                                <label class="label">
                                                                    <span class="label-text">Amount</span>
                                                                </label>
                                                                <input type="number" name="amount"
                                                                    value="{{ $fee->amount }}" step="0.01"
                                                                    min="0" class="input input-bordered"
                                                                    required>
                                                            </div>
                                                        </div>

                                                        <!-- Payment Agreement -->
                                                        <div class="form-control mt-4">
                                                            <label class="label">
                                                                <span class="label-text font-medium">Payment
                                                                    Agreement</span>
                                                            </label>
                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                                <label
                                                                    class="label cursor-pointer justify-start gap-3 p-4 border rounded-lg hover:bg-gray-50">
                                                                    <input type="radio" name="payment_agreement"
                                                                        value="full"
                                                                        {{ $fee->payment_agreement == 'full' ? 'checked' : '' }}
                                                                        class="radio radio-accent" required>
                                                                    <div class="flex-1">
                                                                        <span class="label-text font-medium">Full
                                                                            Payment</span>
                                                                        <p class="text-xs text-gray-500 mt-1">Pay the
                                                                            entire amount at once</p>
                                                                    </div>
                                                                </label>
                                                                <label
                                                                    class="label cursor-pointer justify-start gap-3 p-4 border rounded-lg hover:bg-gray-50">
                                                                    <input type="radio" name="payment_agreement"
                                                                        value="installment"
                                                                        {{ $fee->payment_agreement == 'installment' ? 'checked' : '' }}
                                                                        class="radio radio-accent" required>
                                                                    <div class="flex-1">
                                                                        <span
                                                                            class="label-text font-medium">Installment</span>
                                                                        <p class="text-xs text-gray-500 mt-1">Pay in
                                                                            multiple installments</p>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <!-- Payment Type Options -->
                                                        <div class="divider text-sm">Payment Type Options</div>

                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <div class="form-control">
                                                                <label
                                                                    class="label cursor-pointer justify-start gap-3">
                                                                    <input type="checkbox" name="is_monthly"
                                                                        value="1"
                                                                        {{ $fee->is_monthly ? 'checked' : '' }}
                                                                        class="checkbox checkbox-sm checkbox-accent">
                                                                    <div>
                                                                        <span class="label-text">Monthly Fee</span>
                                                                        <p class="text-xs text-gray-500">Recurring
                                                                            monthly payment</p>
                                                                    </div>
                                                                </label>
                                                            </div>

                                                            <div class="form-control">
                                                                <label
                                                                    class="label cursor-pointer justify-start gap-3">
                                                                    <input type="checkbox" name="is_onetime_fee"
                                                                        value="1"
                                                                        {{ $fee->is_onetime_fee ? 'checked' : '' }}
                                                                        class="checkbox checkbox-sm checkbox-accent">
                                                                    <div>
                                                                        <span class="label-text">One-time Fee</span>
                                                                        <p class="text-xs text-gray-500">Single payment
                                                                            only</p>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="modal-action">
                                                            <button type="button"
                                                                onclick="editFeeModal{{ $fee->id }}.close()"
                                                                class="btn btn-ghost">Cancel</button>
                                                            <button type="submit" class="btn btn-accent">Update
                                                                Fee</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <form method="dialog" class="modal-backdrop">
                                                    <button>close</button>
                                                </form>
                                            </dialog>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <i class="fi fi-rr-inbox text-4xl mb-2"></i>
                                <p>No fees added yet</p>
                            </div>
                        @endif
                    </div>

                    <!-- Add Fee Modal -->
                    <dialog id="addFeeModal{{ $bracket->id }}" class="modal">
                        <div class="modal-box max-w-2xl">
                            <h3 class="font-bold text-lg mb-4">Add Fee to {{ $bracket->name }}</h3>
                            <form action="{{ route('admin.tuition-fee.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="tuition_fee_bracket_id" value="{{ $bracket->id }}">

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Fee Name -->
                                    <div class="form-control md:col-span-2">
                                        <label class="label">
                                            <span class="label-text">Fee Name</span>
                                        </label>
                                        <input type="text" name="name" class="input input-bordered"
                                            placeholder="e.g., Tuition Fee, Laboratory Fee" required>
                                    </div>

                                    <!-- Type -->
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text">Type</span>
                                        </label>
                                        <select name="type" class="select select-bordered" required>
                                            <option value="">Select Type</option>
                                            <option value="Tuition">Tuition</option>
                                            <option value="Miscellaneous">Miscellaneous</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>

                                    <!-- Amount -->
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text">Amount</span>
                                        </label>
                                        <input type="number" name="amount" step="0.01" min="0"
                                            class="input input-bordered" placeholder="0.00" required>
                                    </div>
                                </div>

                                <!-- Payment Agreement -->
                                <div class="form-control mt-4">
                                    <label class="label">
                                        <span class="label-text font-medium">Payment Agreement</span>
                                    </label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <label
                                            class="label cursor-pointer justify-start gap-3 p-4 border rounded-lg hover:bg-gray-50">
                                            <input type="radio" name="payment_agreement" value="full"
                                                class="radio radio-accent" required>
                                            <div class="flex-1">
                                                <span class="label-text font-medium">Full Payment</span>
                                                <p class="text-xs text-gray-500 mt-1">Pay the entire amount at once</p>
                                            </div>
                                        </label>
                                        <label
                                            class="label cursor-pointer justify-start gap-3 p-4 border rounded-lg hover:bg-gray-50">
                                            <input type="radio" name="payment_agreement" value="installment"
                                                class="radio radio-accent" required>
                                            <div class="flex-1">
                                                <span class="label-text font-medium">Installment</span>
                                                <p class="text-xs text-gray-500 mt-1">Pay in multiple installments</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Payment Type Options -->
                                <div class="divider text-sm">Payment Type Options</div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="form-control">
                                        <label class="label cursor-pointer justify-start gap-3">
                                            <input type="checkbox" name="is_monthly" value="1"
                                                class="checkbox checkbox-sm checkbox-accent">
                                            <div>
                                                <span class="label-text">Monthly Fee</span>
                                                <p class="text-xs text-gray-500">Recurring monthly payment</p>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="form-control">
                                        <label class="label cursor-pointer justify-start gap-3">
                                            <input type="checkbox" name="is_onetime_fee" value="1"
                                                class="checkbox checkbox-sm checkbox-accent">
                                            <div>
                                                <span class="label-text">One-time Fee</span>
                                                <p class="text-xs text-gray-500">Single payment only</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <div class="modal-action">
                                    <button type="button" onclick="addFeeModal{{ $bracket->id }}.close()"
                                        class="btn btn-ghost">Cancel</button>
                                    <button type="submit" class="btn btn-accent">Add Fee</button>
                                </div>
                            </form>
                        </div>
                        <form method="dialog" class="modal-backdrop">
                            <button>close</button>
                        </form>
                    </dialog>

                    <!-- Edit Bracket Modal -->
                    <dialog id="editBracketModal{{ $bracket->id }}" class="modal">
                        <div class="modal-box">
                            <h3 class="font-bold text-lg mb-4">Edit Bracket</h3>
                            <form action="{{ route('admin.tuition-fee-brackets.update', $bracket->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-control mb-4">
                                    <label class="label">
                                        <span class="label-text">Bracket Name</span>
                                    </label>
                                    <input type="text" name="name" value="{{ $bracket->name }}"
                                        class="input input-bordered" required>
                                </div>

                                <div class="form-control mb-4">
                                    <label class="label">
                                        <span class="label-text">Description</span>
                                    </label>
                                    <textarea name="description" class="textarea textarea-bordered" rows="3">{{ $bracket->description }}</textarea>
                                </div>

                                <div class="modal-action">
                                    <button type="button" onclick="editBracketModal{{ $bracket->id }}.close()"
                                        class="btn btn-ghost">Cancel</button>
                                    <button type="submit" class="btn btn-accent">Update Bracket</button>
                                </div>
                            </form>
                        </div>
                        <form method="dialog" class="modal-backdrop">
                            <button>close</button>
                        </form>
                    </dialog>
                </div>
            @empty
                <div class="text-center py-16 bg-white rounded-lg">
                    <i class="fi fi-rr-money-bill-wave text-6xl text-gray-400 mb-4"></i>
                    <h3 class="text-xl font-medium text-gray-700 mb-2">No Fee Brackets Yet</h3>
                    <p class="text-gray-500 mb-6">Get started by creating your first tuition fee bracket</p>
                    <button onclick="createBracketModal.showModal()" class="btn btn-accent gap-2">
                        <i class="fi fi-rr-plus"></i>
                        Create Fee Bracket
                    </button>
                </div>
            @endforelse
        </div>

        <!-- Create Bracket Modal -->
        <dialog id="createBracketModal" class="modal">
            <div class="modal-box">
                <h3 class="font-bold text-lg mb-4">Create New Fee Bracket</h3>
                <form action="{{ route('admin.tuition-fee-brackets.store') }}" method="POST">
                    @csrf

                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text">Bracket Name</span>
                        </label>
                        <input type="text" name="name" class="input input-bordered"
                            placeholder="e.g., Grade 1, Junior High School" required>
                    </div>

                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text">Description</span>
                        </label>
                        <textarea name="description" class="textarea textarea-bordered" rows="3"
                            placeholder="Brief description of this fee bracket"></textarea>
                    </div>

                    <div class="modal-action">
                        <button type="button" onclick="createBracketModal.close()"
                            class="btn btn-ghost">Cancel</button>
                        <button type="submit" class="btn btn-accent">Create Bracket</button>
                    </div>
                </form>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>
    </div>
</x-dashboard.admin.base>
