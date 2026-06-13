<x-dashboard.admin.base>
    <x-dashboard.page-title :title="$teacher->name" :back_url="route('admin.users.teacher.index')">
        <x-slot name="other">
            <a href="{{ route('admin.users.teacher.edit', $teacher->id) }}"
               class="btn btn-accent btn-sm gap-2 text-white">
                <i class="fi fi-rr-edit"></i>
                <span class="hidden sm:inline">Edit</span>
            </a>
        </x-slot>
    </x-dashboard.page-title>

    <x-notification-message />

    <div class="space-y-6">

        {{-- Profile Header --}}
        <div class="bg-base-100 rounded-lg shadow-lg p-6">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">

                {{-- Avatar --}}
                <div class="shrink-0">
                    <div class="avatar placeholder">
                        <div class="bg-accent text-white rounded-full w-24 h-24 ring-2 ring-accent ring-offset-2">
                            <span class="text-3xl font-bold">{{ strtoupper(substr($teacher->name, 0, 1)) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Identity --}}
                <div class="flex-1 text-center sm:text-left">
                    <h2 class="text-xl font-bold text-gray-800">{{ $teacher->name }}</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ $teacher->email }}</p>
                    <p class="text-xs text-gray-400 mt-1">
                        Joined {{ \Carbon\Carbon::parse($teacher->created_at)->format('F d, Y') }}
                    </p>

                    {{-- Grade level badges --}}
                    @php $grades = $teacher->teacherClassrooms->pluck('strand.name')->unique()->filter()->values(); @endphp
                    @if($grades->count())
                        <div class="mt-3 flex flex-wrap justify-center sm:justify-start gap-2">
                            @foreach($grades as $grade)
                                <span class="badge badge-accent">{{ $grade }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Quick Stats --}}
                <div class="grid grid-cols-2 gap-3 w-full sm:w-auto mt-2 sm:mt-0">
                    <div class="bg-accent/10 rounded-lg p-3 text-center">
                        <p class="text-2xl font-bold text-accent">{{ $teacher->teacherClassrooms->count() }}</p>
                        <p class="text-xs text-gray-500 mt-1">Classrooms</p>
                    </div>
                    <div class="bg-primary/10 rounded-lg p-3 text-center">
                        <p class="text-2xl font-bold text-accent">{{ $grades->count() }}</p>
                        <p class="text-xs text-gray-500 mt-1">Grade Levels</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Personal Information --}}
        @if($teacher->profile)
            <div class="bg-base-100 rounded-lg shadow-lg p-6">
                <div class="flex items-center gap-2 mb-4">
                    <i class="fi fi-rr-user text-accent"></i>
                    <h3 class="font-bold text-accent">Personal Information</h3>
                </div>
                <dl class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                    <div>
                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Last Name</dt>
                        <dd class="font-medium text-gray-800 mt-0.5">{{ $teacher->profile->last_name ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 uppercase tracking-wide">First Name</dt>
                        <dd class="font-medium text-gray-800 mt-0.5">{{ $teacher->profile->first_name ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Middle Name</dt>
                        <dd class="font-medium text-gray-800 mt-0.5">{{ $teacher->profile->middle_name ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Sex</dt>
                        <dd class="font-medium text-gray-800 mt-0.5">{{ $teacher->profile->sex ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Contact #</dt>
                        <dd class="font-medium text-gray-800 mt-0.5">{{ $teacher->profile->contact_no ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 uppercase tracking-wide">Address</dt>
                        <dd class="font-medium text-gray-800 mt-0.5">{{ $teacher->profile->address ?? '—' }}</dd>
                    </div>
                </dl>
            </div>
        @endif

        {{-- Classrooms Section --}}
        <div class="bg-base-100 rounded-lg shadow-lg p-6">
            <div class="flex items-center gap-2 mb-5">
                <i class="fi fi-rr-chalkboard-user text-accent"></i>
                <h3 class="font-bold text-accent">Assigned Classrooms</h3>
                <span class="badge badge-ghost badge-sm ml-auto">{{ $teacher->teacherClassrooms->count() }}</span>
                <button onclick="document.getElementById('assign-modal').showModal()"
                        class="btn btn-accent btn-sm gap-2 text-white">
                    <i class="fi fi-rr-plus"></i>
                    <span class="hidden sm:inline">Assign Classroom</span>
                </button>
            </div>

            @if($teacher->teacherClassrooms->count())

                {{-- Desktop Table --}}
                <div class="hidden sm:block overflow-x-auto rounded-lg border border-base-200">
                    <table class="table table-zebra w-full text-sm">
                        <thead>
                            <tr class="bg-base-200 text-gray-600 uppercase text-xs tracking-wide">
                                <th>Classroom</th>
                                <th>Subject</th>
                                <th>Grade Level</th>
                                <th>School Year</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teacher->teacherClassrooms as $classroom)
                                <tr class="hover">
                                    <td>
                                        <p class="font-semibold text-gray-800">{{ $classroom->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $classroom->class_code ?? '' }}</p>
                                    </td>
                                    <td>{{ $classroom->subject?->name ?? '—' }}</td>
                                    <td>
                                        @if($classroom->strand)
                                            <span class="badge badge-accent badge-sm">{{ $classroom->strand->name }}</span>
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>
                                    <td class="text-xs text-gray-500">{{ $classroom->academicYear?->name ?? '—' }}</td>
                                    <td class="text-right">
                                        <form action="{{ route('admin.users.teacher.remove-classroom', [$teacher->id, $classroom->id]) }}"
                                              method="POST" class="inline-block"
                                              onsubmit="return confirm('Remove this classroom from the teacher?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-ghost btn-xs text-error" title="Remove">
                                                <i class="fi fi-rr-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile Cards --}}
                <div class="block sm:hidden space-y-3">
                    @foreach($teacher->teacherClassrooms as $classroom)
                        <div class="rounded-lg border border-base-200 p-4 space-y-2">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-semibold text-gray-800 text-sm">{{ $classroom->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $classroom->class_code ?? '' }}</p>
                                </div>
                                @if($classroom->strand)
                                    <span class="badge badge-accent badge-sm">{{ $classroom->strand->name }}</span>
                                @endif
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                                <div>
                                    <span class="text-gray-400">Subject</span>
                                    <p class="font-medium">{{ $classroom->subject?->name ?? '—' }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-400">School Year</span>
                                    <p class="font-medium">{{ $classroom->academicYear?->name ?? '—' }}</p>
                                </div>
                            </div>
                            <form action="{{ route('admin.users.teacher.remove-classroom', [$teacher->id, $classroom->id]) }}"
                                  method="POST"
                                  onsubmit="return confirm('Remove this classroom from the teacher?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-ghost btn-xs text-error gap-1 mt-1">
                                    <i class="fi fi-rr-trash"></i> Remove
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>

            @else
                <div class="text-center py-12 text-gray-400">
                    <i class="fi fi-rr-chalkboard-user block text-3xl mb-2"></i>
                    <p class="text-sm">No classrooms assigned yet</p>
                    <button onclick="document.getElementById('assign-modal').showModal()"
                            class="btn btn-accent btn-sm mt-4 gap-2 text-white">
                        <i class="fi fi-rr-plus"></i> Assign First Classroom
                    </button>
                </div>
            @endif
        </div>

    </div>

    {{-- Assign Classroom Modal --}}
    <dialog id="assign-modal" class="modal">
        <div class="modal-box w-full max-w-lg">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>

            <div class="flex items-center gap-2 mb-5">
                <i class="fi fi-rr-chalkboard-user text-accent text-xl"></i>
                <h3 class="font-bold text-lg text-accent">Assign Classroom</h3>
            </div>

            <form action="{{ route('admin.users.teacher.assign-classroom', $teacher->id) }}" method="POST"
                  class="space-y-4">
                @csrf

                <div>
                    <label class="label pb-1">
                        <span class="label-text font-medium">Classroom Name <span class="text-error">*</span></span>
                    </label>
                    <input type="text" name="name" placeholder="e.g. Math – Grade 7 Section A"
                           class="input input-bordered w-full @error('name') input-error @enderror"
                           value="{{ old('name') }}" required />
                    @error('name')
                        <p class="text-error text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="label pb-1">
                        <span class="label-text font-medium">Description <span class="text-error">*</span></span>
                    </label>
                    <textarea name="description" rows="2" placeholder="Brief description of this classroom..."
                              class="textarea textarea-bordered w-full @error('description') textarea-error @enderror"
                              required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-error text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="label pb-1">
                        <span class="label-text font-medium">Grade Level <span class="text-error">*</span></span>
                    </label>
                    <select name="strand_id" class="select select-bordered w-full @error('strand_id') select-error @enderror" required>
                        <option value="" disabled selected>Select grade level...</option>
                        @foreach($strands as $strand)
                            <option value="{{ $strand->id }}" {{ old('strand_id') == $strand->id ? 'selected' : '' }}>
                                {{ $strand->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('strand_id')
                        <p class="text-error text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="label pb-1">
                        <span class="label-text font-medium">Subject <span class="text-error">*</span></span>
                    </label>
                    <select name="subject_id" class="select select-bordered w-full @error('subject_id') select-error @enderror" required>
                        <option value="" disabled selected>Select subject...</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}{{ $subject->subject_code ? " ({$subject->subject_code})" : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <p class="text-error text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="label pb-1">
                        <span class="label-text font-medium">School Year <span class="text-error">*</span></span>
                    </label>
                    <select name="academic_year_id" class="select select-bordered w-full @error('academic_year_id') select-error @enderror" required>
                        <option value="" disabled selected>Select school year...</option>
                        @foreach($academicYears as $ay)
                            <option value="{{ $ay->id }}" {{ old('academic_year_id') == $ay->id ? 'selected' : '' }}>
                                {{ $ay->name }}{{ $ay->status === 'active' ? ' (Active)' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('academic_year_id')
                        <p class="text-error text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="modal-action pt-2">
                    <button type="button" onclick="document.getElementById('assign-modal').close()"
                            class="btn btn-ghost">Cancel</button>
                    <button type="submit" class="btn btn-accent text-white gap-2">
                        <i class="fi fi-rr-check"></i> Assign
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    {{-- Re-open modal on validation error --}}
    @if($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                document.getElementById('assign-modal').showModal();
            });
        </script>
    @endif

</x-dashboard.admin.base>
