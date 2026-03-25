<x-dashboard.admin.base>
    <x-dashboard.page-title :title="_('Grade Levels')" :create_url="route('admin.strands.create')" />

    <div class="container max-w-7xl p-4 sm:p-6 mx-auto">
        <x-notification-message />
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-error">
                    {{ $error }}
                </div>
            @endforeach
        @endif
        <div class="panel flex flex-col gap-4 min-h-96">

            <!-- Desktop Table -->
            <div class="overflow-x-auto hidden md:block bg-white rounded-lg shadow-sm">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th class="hidden lg:table-cell">Acronym</th>
                            <th class="hidden lg:table-cell">Sections</th>
                            <th class="hidden lg:table-cell">Tuition Fees</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($strands as $strand)
                            <tr class="hover:bg-gray-50">
                                <th>{{ $loop->iteration }}</th>
                                <td class="max-w-xs truncate">{{ $strand->name }}</td>
                                <td class="hidden lg:table-cell">{{ $strand->acronym }}</td>
                                <td class="hidden lg:table-cell">
                                    <span class="badge badge-primary badge-sm">
                                        {{ $strand->sections->count() }} sections
                                    </span>
                                </td>
                                <td class="hidden lg:table-cell">
                                    <span class="badge badge-accent badge-sm">
                                        {{ $strand->tuitionFees->count() }} fees assigned
                                    </span>
                                </td>
                                <td class="flex justify-end items-center gap-3">
                                    <button onclick="sectionModal{{ $strand->id }}.showModal()"
                                        class="btn btn-xs btn-primary" aria-label="Manage Sections">
                                        <i class="fi fi-rr-users-alt"></i>
                                    </button>

                                    <button onclick="tuitionFeeModal{{ $strand->id }}.showModal()"
                                        class="btn btn-xs btn-info" aria-label="Set Tuition">
                                        <i class="fi fi-rr-money-bill-wave"></i>
                                    </button>

                                    <a href="{{ route('admin.strands.show', ['strand' => $strand->id]) }}"
                                        class="btn btn-xs btn-accent" aria-label="View">
                                        <i class="fi fi-rr-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.strands.edit', ['strand' => $strand->id]) }}"
                                        class="btn btn-xs btn-success" aria-label="Edit">
                                        <i class="fi fi-rr-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.strands.destroy', ['strand' => $strand->id]) }}"
                                        method="post"
                                        onsubmit="return confirm('Are you sure you want to delete this strand?')">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-xs btn-error" aria-label="Delete">
                                            <i class="fi fi-rr-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Section Management Modal -->
                            <dialog id="sectionModal{{ $strand->id }}" class="modal">
                                <div class="modal-box max-w-5xl">
                                    <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
                                        <i class="fi fi-rr-users-alt"></i>
                                        Manage Sections for {{ $strand->name }}
                                    </h3>

                                    <!-- Add New Section Form -->
                                    <form action="{{ route('admin.strands.sections.store') }}" method="POST" class="mb-6 p-4 bg-blue-50 rounded-lg">
                                        @csrf
                                        <h4 class="font-semibold mb-3">Add New Section</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="form-control">
                                                <label class="label">
                                                    <span class="label-text font-medium">Section Name</span>
                                                </label>
                                                <input type="text" name="name" placeholder="e.g., St. Peter"
                                                       class="input input-bordered input-sm" required>
                                            </div>

                                            <div class="form-control">
                                                <label class="label">
                                                    <span class="label-text font-medium">Grade Level</span>
                                                </label>


                                                <input type="text" name="grade_level" value="{{$strand->name}}"   class="input input-bordered input-sm">

                                                <input type="hidden" name="strand_id" value="{{ $strand->id }}">


                                            </div>

                                            <div class="form-control">
                                                <label class="label">
                                                    <span class="label-text font-medium">Capacity</span>
                                                </label>
                                                <input type="number" name="capacity" min="1" max="100"
                                                       value="40" class="input input-bordered input-sm" required>
                                            </div>

                                            <div class="form-control">
                                                <label class="label">
                                                    <span class="label-text font-medium">Description</span>
                                                </label>
                                                <input type="text" name="description" placeholder="Optional"
                                                       class="input input-bordered input-sm">
                                            </div>
                                        </div>

                                        <div class="flex justify-end mt-4">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fi fi-rr-plus mr-2"></i>
                                                Add Section
                                            </button>
                                        </div>
                                    </form>

                                    <!-- Existing Sections List -->
                                    <div class="space-y-3 max-h-96 overflow-y-auto">
                                        <h4 class="font-semibold mb-3">Existing Sections</h4>
                                        @forelse($strand->sections as $section)
                                            <div class="border rounded-lg p-4 {{ $section->is_active ? 'bg-white' : 'bg-gray-50' }}">
                                                <div class="flex items-start justify-between">
                                                    <div class="flex-1">
                                                        <div class="flex items-center gap-3 mb-2">
                                                            <h5 class="font-semibold text-lg">{{ $section->name }}</h5>
                                                            <span class="badge badge-sm badge-ghost">Grade {{ $section->grade_level }}</span>
                                                            <span class="badge badge-sm {{ $section->is_active ? 'badge-success' : 'badge-error' }}">
                                                                {{ $section->is_active ? 'Active' : 'Inactive' }}
                                                            </span>
                                                        </div>

                                                        <div class="flex flex-wrap gap-3 text-sm text-gray-600">
                                                            <div class="flex items-center gap-1">
                                                                <i class="fi fi-rr-users text-xs"></i>
                                                                <span>{{ $section->student_count }}/{{ $section->capacity }} students</span>
                                                            </div>
                                                            @if($section->description)
                                                                <div class="flex items-center gap-1">
                                                                    <i class="fi fi-rr-info text-xs"></i>
                                                                    <span>{{ $section->description }}</span>
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <!-- Progress Bar -->
                                                        <div class="mt-3">
                                                            <div class="flex justify-between text-xs mb-1">
                                                                <span>Enrollment</span>
                                                                <span>{{ number_format(($section->student_count / $section->capacity) * 100, 1) }}%</span>
                                                            </div>
                                                            <progress class="progress progress-accent w-full"
                                                                      value="{{ $section->student_count }}"
                                                                      max="{{ $section->capacity }}"></progress>
                                                        </div>
                                                    </div>

                                                    <div class="flex gap-2 ml-4">
                                                        <button onclick="editSectionModal{{ $section->id }}.showModal()"
                                                                class="btn btn-xs btn-ghost">
                                                            <i class="fi fi-rr-edit"></i>
                                                        </button>

                                                        <form action="{{ route('admin.strands.sections.destroy', [$strand->id, $section->id]) }}"
                                                              method="POST"
                                                              onsubmit="return confirm('Delete this section?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-xs btn-ghost text-error"
                                                                    {{ $section->student_count > 0 ? 'disabled' : '' }}>
                                                                <i class="fi fi-rr-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Edit Section Modal -->
                                            <dialog id="editSectionModal{{ $section->id }}" class="modal">
                                                <div class="modal-box">
                                                    <h3 class="font-bold text-lg mb-4">Edit Section: {{ $section->name }}</h3>

                                                    <form action="{{ route('admin.strands.sections.update', [$strand->id, $section->id]) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="space-y-4">
                                                            <div class="form-control">
                                                                <label class="label">
                                                                    <span class="label-text font-medium">Section Name</span>
                                                                </label>
                                                                <input type="text" name="name" value="{{ $section->name }}"
                                                                       class="input input-bordered" required>
                                                            </div>

                                                            <div class="form-control">
                                                                <label class="label">
                                                                    <span class="label-text font-medium">Grade Level</span>
                                                                </label>
                                                                <select name="grade_level" class="select select-bordered" required>
                                                                    @for($i = 7; $i <= 12; $i++)
                                                                        <option value="{{ $i }}" {{ $section->grade_level == $i ? 'selected' : '' }}>
                                                                            Grade {{ $i }}
                                                                        </option>
                                                                    @endfor
                                                                </select>
                                                            </div>

                                                            <div class="form-control">
                                                                <label class="label">
                                                                    <span class="label-text font-medium">Capacity</span>
                                                                </label>
                                                                <input type="number" name="capacity" min="{{ $section->student_count }}"
                                                                       max="100" value="{{ $section->capacity }}"
                                                                       class="input input-bordered" required>
                                                                <label class="label">
                                                                    <span class="label-text-alt">Current students: {{ $section->student_count }}</span>
                                                                </label>
                                                            </div>

                                                            <div class="form-control">
                                                                <label class="label">
                                                                    <span class="label-text font-medium">Description</span>
                                                                </label>
                                                                <input type="text" name="description" value="{{ $section->description }}"
                                                                       class="input input-bordered">
                                                            </div>

                                                            <div class="form-control">
                                                                <label class="label cursor-pointer justify-start gap-3">
                                                                    <input type="checkbox" name="is_active"
                                                                           {{ $section->is_active ? 'checked' : '' }}
                                                                           class="checkbox checkbox-accent">
                                                                    <span class="label-text font-medium">Active</span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="modal-action">
                                                            <button type="button" onclick="editSectionModal{{ $section->id }}.close()"
                                                                    class="btn btn-ghost">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="fi fi-rr-check mr-2"></i>
                                                                Update Section
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <form method="dialog" class="modal-backdrop">
                                                    <button>close</button>
                                                </form>
                                            </dialog>
                                        @empty
                                            <p class="text-center text-gray-500 py-8">No sections created yet.</p>
                                        @endforelse
                                    </div>

                                    <div class="modal-action">
                                        <button type="button" onclick="sectionModal{{ $strand->id }}.close()"
                                                class="btn btn-ghost">Close</button>
                                    </div>
                                </div>
                                <form method="dialog" class="modal-backdrop">
                                    <button>close</button>
                                </form>
                            </dialog>

                            <!-- Tuition Fee Modal -->
                            <dialog id="tuitionFeeModal{{ $strand->id }}" class="modal">
                                <div class="modal-box max-w-4xl">
                                    <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
                                        <i class="fi fi-rr-money-bill-wave"></i>
                                        Set Tuition Fees for {{ $strand->name }}
                                    </h3>

                                    <form action="{{ route('admin.strands.tuition-fees.update', $strand->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')

                                        <!-- Current Assigned Fees -->
                                        @if ($strand->tuitionFees->count() > 0)
                                            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                                                <h4 class="font-semibold text-sm mb-3 text-blue-800">Currently Assigned
                                                    Fees</h4>
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach ($strand->tuitionFees as $fee)
                                                        <div class="badge badge-accent gap-2">
                                                            {{ $fee->name }} -
                                                            ₱{{ number_format($fee->amount, 2) }}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Fee Brackets with Checkboxes -->
                                        <div class="space-y-4 max-h-96 overflow-y-auto">
                                            @foreach ($brackets as $bracket)
                                                <div class="border rounded-lg p-4">
                                                    <div class="flex items-center justify-between mb-3">
                                                        <div>
                                                            <h4 class="font-semibold">{{ $bracket->name }}</h4>
                                                            <p class="text-sm text-gray-600">
                                                                {{ $bracket->description }}</p>
                                                        </div>
                                                        <span
                                                            class="badge {{ $bracket->is_active ? 'badge-success' : 'badge-ghost' }}">
                                                            {{ $bracket->is_active ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </div>

                                                    @if ($bracket->fees->count() > 0)
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                            @foreach ($bracket->fees as $fee)
                                                                <label
                                                                    class="flex items-start gap-3 p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                                                                    <input type="checkbox" name="tuition_fees[]"
                                                                        value="{{ $fee->id }}"
                                                                        {{ $strand->tuitionFees->contains($fee->id) ? 'checked' : '' }}
                                                                        class="checkbox checkbox-sm checkbox-accent mt-1">
                                                                    <div class="flex-1">
                                                                        <div class="font-medium text-sm">
                                                                            {{ $fee->name }}
                                                                        </div>
                                                                        <div class="flex items-center gap-2 mt-1">
                                                                            <span
                                                                                class="text-accent font-semibold">₱{{ number_format($fee->amount, 2) }}</span>
                                                                            <span
                                                                                class="badge badge-xs badge-outline">{{ $fee->type }}</span>
                                                                            @if ($fee->is_monthly)
                                                                                <span
                                                                                    class="badge badge-xs badge-info">Monthly</span>
                                                                            @endif
                                                                            @if ($fee->is_onetime_fee)
                                                                                <span
                                                                                    class="badge badge-xs badge-warning">One-time</span>
                                                                            @endif
                                                                            @if ($fee->payment_agreement == 'full_payment')
                                                                                <span
                                                                                    class="badge badge-xs badge-success">Full
                                                                                    Payment</span>
                                                                            @elseif($fee->payment_agreement == 'installment')
                                                                                <span
                                                                                    class="badge badge-xs badge-primary">Installment</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <p class="text-sm text-gray-500 text-center py-4">No fees in
                                                            this bracket</p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- Total Calculation -->
                                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                            <div class="flex justify-between items-center">
                                                <span class="font-semibold">Selected Fees Total:</span>
                                                <span class="text-2xl font-bold text-accent"
                                                    id="totalAmount{{ $strand->id }}">
                                                    ₱0.00
                                                </span>
                                            </div>
                                        </div>

                                        <div class="modal-action">
                                            <button type="button" onclick="tuitionFeeModal{{ $strand->id }}.close()"
                                                class="btn btn-ghost">Cancel</button>
                                            <button type="submit" class="btn btn-accent">
                                                <i class="fi fi-rr-check"></i>
                                                Update Tuition Fees
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <form method="dialog" class="modal-backdrop">
                                    <button>close</button>
                                </form>
                            </dialog>

                            @push('scripts')
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const modal{{ $strand->id }} = document.getElementById('tuitionFeeModal{{ $strand->id }}');
                                        const checkboxes{{ $strand->id }} = modal{{ $strand->id }}.querySelectorAll(
                                            'input[name="tuition_fees[]"]');
                                        const totalAmount{{ $strand->id }} = document.getElementById('totalAmount{{ $strand->id }}');

                                        const feeAmounts{{ $strand->id }} = {
                                            @foreach ($brackets as $bracket)
                                                @foreach ($bracket->fees as $fee)
                                                    {{ $fee->id }}: {{ $fee->amount }},
                                                @endforeach
                                            @endforeach
                                        };

                                        function updateTotal{{ $strand->id }}() {
                                            let total = 0;
                                            checkboxes{{ $strand->id }}.forEach(checkbox => {
                                                if (checkbox.checked) {
                                                    total += parseFloat(feeAmounts{{ $strand->id }}[checkbox.value] || 0);
                                                }
                                            });
                                            totalAmount{{ $strand->id }}.textContent = '₱' + total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g,
                                                '$&,');
                                        }

                                        checkboxes{{ $strand->id }}.forEach(checkbox => {
                                            checkbox.addEventListener('change', updateTotal{{ $strand->id }});
                                        });

                                        updateTotal{{ $strand->id }}();
                                    });
                                </script>
                            @endpush
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-6">
                                    <div class="flex flex-col items-center justify-center text-gray-500">
                                        <i class="fi fi-rr-book text-3xl mb-2"></i>
                                        <p>No strands found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="md:hidden space-y-3">
                @forelse ($strands as $strand)
                    <div class="bg-white rounded-lg shadow-sm p-4">
                        <div class="flex items-start gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <div class="min-w-0">
                                        <div class="font-semibold text-sm truncate">{{ $strand->name }}</div>
                                        <div class="text-xs text-gray-500 truncate">{{ $strand->acronym }}</div>
                                        <div class="mt-1 flex gap-2">
                                            <span class="badge badge-primary badge-xs">
                                                {{ $strand->sections->count() }} sections
                                            </span>
                                            <span class="badge badge-accent badge-xs">
                                                {{ $strand->tuitionFees->count() }} fees
                                            </span>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <div class="dropdown dropdown-end">
                                            <button tabindex="0" class="btn btn-ghost btn-sm" aria-label="Actions">
                                                <i class="fi fi-rr-menu-dots"></i>
                                            </button>
                                            <ul tabindex="0"
                                                class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-48 z-10">
                                                <li>
                                                    <button onclick="sectionModal{{ $strand->id }}.showModal()"
                                                        class="flex items-center gap-2">
                                                        <i class="fi fi-rr-users-alt"></i> Sections
                                                    </button>
                                                </li>
                                                <li>
                                                    <button onclick="tuitionFeeModal{{ $strand->id }}.showModal()"
                                                        class="flex items-center gap-2">
                                                        <i class="fi fi-rr-money-bill-wave"></i> Set Tuition
                                                    </button>
                                                </li>
                                                <li>
                                                    <a href="{{ route('admin.strands.show', ['strand' => $strand->id]) }}"
                                                        class="flex items-center gap-2">
                                                        <i class="fi fi-rr-eye"></i> View
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('admin.strands.edit', ['strand' => $strand->id]) }}"
                                                        class="flex items-center gap-2">
                                                        <i class="fi fi-rr-edit"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <form
                                                        action="{{ route('admin.strands.destroy', ['strand' => $strand->id]) }}"
                                                        method="post"
                                                        onsubmit="return confirm('Delete this strand?')">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit"
                                                            class="w-full text-left flex items-center gap-2 text-error">
                                                            <i class="fi fi-rr-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-500">
                        <i class="fi fi-rr-book text-3xl mb-2"></i>
                        <p>No strands found</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $strands->links() }}
            </div>
        </div>
    </div>
</x-dashboard.admin.base>
