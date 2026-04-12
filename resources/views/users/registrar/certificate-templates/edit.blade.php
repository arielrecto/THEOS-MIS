<x-dashboard.registrar.base>
    <x-dashboard.page-title :title="_('Edit Certificate Template')" />

    <div class="p-6 bg-white rounded-lg shadow-lg">
        <form method="POST" action="{{ route('registrar.certificate-templates.update', $template) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">
                <!-- Template Name -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Template Name</span>
                    </label>
                    <input type="text" name="name" value="{{ $template->name }}"
                           class="input input-bordered" required>
                </div>

                <!-- Certificate Title -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Certificate Title</span>
                    </label>
                    <input type="text" name="title" value="{{ $template->title }}"
                           class="input input-bordered" required>
                </div>

                <!-- Available Placeholders -->
                <div class="alert alert-info">
                    <div>
                        <h3 class="font-bold">Available Placeholders:</h3>
                        <div class="grid grid-cols-2 gap-2 mt-2 text-sm">
                            @foreach($placeholders as $placeholder => $description)
                                <div>
                                    <code class="bg-base-200 px-2 py-1 rounded">{{ $placeholder }}</code>
                                    <span class="text-xs">- {{ $description }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Content Editor -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Certificate Content</span>
                        <span class="label-text-alt text-xs">Use placeholders like @{{student_name}}</span>
                    </label>
                    <textarea name="content" rows="10"
                              class="textarea textarea-bordered font-mono"
                              required>{{ $template->content }}</textarea>
                </div>

                <!-- Signatory Information -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Primary Signatory Name (School Head)</span>
                        </label>
                        <input type="text" name="signatory_name"
                               value="{{ $template->signatory_name }}"
                               class="input input-bordered">
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Primary Signatory Title</span>
                        </label>
                        <input type="text" name="signatory_title"
                               value="{{ $template->signatory_title }}"
                               class="input input-bordered">
                    </div>
                </div>

                <!-- Additional Signatories (For Form 137) -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Class Adviser Name (Optional)</span>
                        </label>
                        <input type="text" name="signatory_name_2"
                               value="{{ $template->signatory_name_2 }}"
                               class="input input-bordered">
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Class Adviser Title</span>
                        </label>
                        <input type="text" name="signatory_title_2"
                               value="{{ $template->signatory_title_2 ?? 'Class Adviser' }}"
                               class="input input-bordered">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">School Registrar Name (Optional)</span>
                        </label>
                        <input type="text" name="signatory_name_3"
                               value="{{ $template->signatory_name_3 }}"
                               class="input input-bordered">
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">School Registrar Title</span>
                        </label>
                        <input type="text" name="signatory_title_3"
                               value="{{ $template->signatory_title_3 ?? 'School Registrar' }}"
                               class="input input-bordered">
                    </div>
                </div>

                <!-- Footer -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Footer Text</span>
                    </label>
                    <input type="text" name="footer" value="{{ $template->footer }}"
                           class="input input-bordered">
                </div>

                <!-- Submit Buttons -->
                <div class="flex gap-4">
                    <button type="submit" class="btn btn-accent">
                        <i class="fi fi-rr-check mr-2"></i>Save Changes
                    </button>
                    <a href="{{ route('registrar.certificate-templates.index') }}"
                       class="btn btn-ghost">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</x-dashboard.registrar.base>
