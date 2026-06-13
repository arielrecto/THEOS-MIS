<x-dashboard.teacher.base>
    <x-dashboard.page-title :back_url="route('teacher.profile.show', $profile->id)" title="Edit Profile" />

    <x-notification-message />

    <form action="{{ route('teacher.profile.update', $profile->id) }}" method="POST"
          enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Profile Picture --}}
        <div class="bg-base-100 rounded-lg shadow-lg p-6">
            <div class="flex items-center gap-2 mb-5">
                <i class="fi fi-rr-camera text-accent"></i>
                <h3 class="font-bold text-accent">Profile Picture</h3>
            </div>

            <div x-data="{
                preview: '{{ $profile->image ?? '' }}',
                setPreview(e) {
                    const file = e.target.files[0];
                    if (!file) return;
                    const reader = new FileReader();
                    reader.onload = ev => this.preview = ev.target.result;
                    reader.readAsDataURL(file);
                }
            }" class="flex flex-col sm:flex-row items-center gap-6">

                {{-- Current / Preview --}}
                <div class="shrink-0">
                    <div class="avatar">
                        <div class="w-24 h-24 rounded-full ring-2 ring-accent ring-offset-2 overflow-hidden bg-base-200">
                            <img :src="preview || 'https://ui-avatars.com/api/?name={{ urlencode($teacher->name) }}&size=256&background=random'"
                                 alt="{{ $teacher->name }}" class="object-cover w-full h-full">
                        </div>
                    </div>
                </div>

                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Upload new photo <span class="text-xs text-gray-400">(JPG, PNG — max 2MB)</span>
                    </label>
                    <input type="file" name="image" accept="image/*"
                           @change="setPreview($event)"
                           class="file-input file-input-bordered file-input-sm w-full max-w-sm" />
                    @error('image')
                        <p class="text-error text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Personal Information --}}
        <div class="bg-base-100 rounded-lg shadow-lg p-6">
            <div class="flex items-center gap-2 mb-5">
                <i class="fi fi-rr-user text-accent"></i>
                <h3 class="font-bold text-accent">Personal Information</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="label pb-1">
                        <span class="label-text font-medium">Last Name <span class="text-error">*</span></span>
                    </label>
                    <input type="text" name="last_name" value="{{ old('last_name', $profile->last_name) }}"
                           class="input input-bordered w-full @error('last_name') input-error @enderror" required />
                    @error('last_name') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="label pb-1">
                        <span class="label-text font-medium">First Name <span class="text-error">*</span></span>
                    </label>
                    <input type="text" name="first_name" value="{{ old('first_name', $profile->first_name) }}"
                           class="input input-bordered w-full @error('first_name') input-error @enderror" required />
                    @error('first_name') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="label pb-1">
                        <span class="label-text font-medium">Middle Name</span>
                    </label>
                    <input type="text" name="middle_name" value="{{ old('middle_name', $profile->middle_name) }}"
                           class="input input-bordered w-full" />
                </div>

                <div>
                    <label class="label pb-1">
                        <span class="label-text font-medium">Sex <span class="text-error">*</span></span>
                    </label>
                    <select name="sex" class="select select-bordered w-full @error('sex') select-error @enderror" required>
                        <option value="male"   {{ old('sex', $profile->sex) === 'male'   ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('sex', $profile->sex) === 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('sex') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="label pb-1">
                        <span class="label-text font-medium">Contact Number</span>
                    </label>
                    <input type="text" name="contact_no" value="{{ old('contact_no', $profile->contact_no) }}"
                           maxlength="11" inputmode="numeric"
                           oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                           class="input input-bordered w-full" />
                </div>

                <div class="sm:col-span-3">
                    <label class="label pb-1">
                        <span class="label-text font-medium">Address <span class="text-error">*</span></span>
                    </label>
                    <input type="text" name="address" value="{{ old('address', $profile->address) }}"
                           class="input input-bordered w-full @error('address') input-error @enderror" required />
                    @error('address') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Account Settings --}}
        <div class="bg-base-100 rounded-lg shadow-lg p-6">
            <div class="flex items-center gap-2 mb-5">
                <i class="fi fi-rr-lock text-accent"></i>
                <h3 class="font-bold text-accent">Account Settings</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="label pb-1">
                        <span class="label-text font-medium">Display Name <span class="text-error">*</span></span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $teacher->name) }}"
                           class="input input-bordered w-full @error('name') input-error @enderror" required />
                    @error('name') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="label pb-1">
                        <span class="label-text font-medium">Email Address <span class="text-error">*</span></span>
                    </label>
                    <input type="email" name="email" value="{{ old('email', $teacher->email) }}"
                           class="input input-bordered w-full @error('email') input-error @enderror" required />
                    @error('email') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="divider text-xs text-gray-400">Change Password (leave blank to keep current)</div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="label pb-1">
                        <span class="label-text font-medium">New Password</span>
                    </label>
                    <input type="password" name="password"
                           class="input input-bordered w-full @error('password') input-error @enderror"
                           placeholder="Min. 8 characters" />
                    @error('password') <p class="text-error text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="label pb-1">
                        <span class="label-text font-medium">Confirm New Password</span>
                    </label>
                    <input type="password" name="password_confirmation"
                           class="input input-bordered w-full"
                           placeholder="Repeat new password" />
                </div>
            </div>
        </div>

        {{-- Assigned Classrooms (read-only) --}}
        <div class="bg-base-100 rounded-lg shadow-lg p-6">
            <div class="flex items-center gap-2 mb-5">
                <i class="fi fi-rr-chalkboard-user text-accent"></i>
                <h3 class="font-bold text-accent">Assigned Classrooms</h3>
                <span class="badge badge-ghost badge-sm ml-auto">{{ $classrooms->count() }}</span>
            </div>

            @if($classrooms->count())
                <div class="overflow-x-auto rounded-lg border border-base-200">
                    <table class="table table-zebra w-full text-sm">
                        <thead>
                            <tr class="bg-base-200 text-gray-600 uppercase text-xs tracking-wide">
                                <th>Classroom</th>
                                <th>Subject</th>
                                <th>Grade Level</th>
                                <th>School Year</th>
                                <th class="text-right">Students</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($classrooms as $classroom)
                                <tr>
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
                                        <span class="badge badge-ghost badge-sm">{{ $classroom->classroom_students_count }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 text-gray-400">
                    <i class="fi fi-rr-chalkboard block text-3xl mb-2"></i>
                    <p class="text-sm">No classrooms assigned yet.</p>
                </div>
            @endif
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-3 pb-4">
            <a href="{{ route('teacher.profile.show', $profile->id) }}" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-accent text-white gap-2">
                <i class="fi fi-rr-check"></i> Save Changes
            </button>
        </div>

    </form>
</x-dashboard.teacher.base>
