<x-dashboard.registrar.base>
    <x-dashboard.page-title :title="'Edit Certificate Template'" :back_url="route('registrar.certificate-templates.index')" />

    <form method="POST" action="{{ route('registrar.certificate-templates.update', $template) }}" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Section 1: Basic Info --}}
        <div class="bg-white rounded-lg shadow-sm border border-base-200 p-6">
            <div class="flex items-center gap-2 mb-5">
                <i class="fi fi-rr-document text-accent text-lg"></i>
                <h2 class="font-semibold text-gray-700">Basic Information</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Template Name <span class="text-error">*</span></span>
                        <span class="label-text-alt text-gray-400 text-xs">Internal reference name</span>
                    </label>
                    <input type="text" name="name" value="{{ $template->name }}"
                           class="input input-bordered @error('name') input-error @enderror"
                           placeholder="e.g. Good Moral Certificate" required>
                    @error('name')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Certificate Title <span class="text-error">*</span></span>
                        <span class="label-text-alt text-gray-400 text-xs">Shown on the printed document</span>
                    </label>
                    <input type="text" name="title" value="{{ $template->title }}"
                           class="input input-bordered @error('title') input-error @enderror"
                           placeholder="e.g. CERTIFICATE OF GOOD MORAL CHARACTER" required>
                    @error('title')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="form-control md:col-span-2">
                    <label class="label">
                        <span class="label-text font-medium">School Address</span>
                        <span class="label-text-alt text-gray-400 text-xs">Shown in the document header</span>
                    </label>
                    <input type="text" name="school_address"
                           value="{{ $template->school_address }}"
                           placeholder="e.g. Brgy. Biga 1, Imus City, Cavite"
                           class="input input-bordered">
                </div>
            </div>
        </div>

        {{-- Section 2: Content Editor --}}
        <div class="bg-white rounded-lg shadow-sm border border-base-200 p-6">
            <div class="flex items-center gap-2 mb-5">
                <i class="fi fi-rr-edit text-accent text-lg"></i>
                <h2 class="font-semibold text-gray-700">Certificate Content</h2>
            </div>

            {{-- Placeholders --}}
            <div class="rounded-lg border border-info/30 bg-info/5 p-4 mb-5">
                <div class="flex items-center gap-2 mb-3">
                    <i class="fi fi-rr-info text-info text-sm"></i>
                    <span class="text-sm font-semibold text-info">Available Placeholders</span>
                    <span class="text-xs text-gray-500 ml-1">— click to copy</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                    @foreach($placeholders as $placeholder => $description)
                        <button type="button"
                            onclick="copyPlaceholder('{{ $placeholder }}')"
                            class="flex items-center gap-2 text-left px-3 py-2 rounded-lg bg-white border border-base-200 hover:border-accent hover:bg-accent/5 transition-colors group">
                            <code class="text-xs font-mono text-accent group-hover:text-accent shrink-0">{{ $placeholder }}</code>
                            <span class="text-xs text-gray-500 truncate">{{ $description }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text font-medium">Body Text <span class="text-error">*</span></span>
                    <span class="label-text-alt text-gray-400 text-xs">Use placeholders like &#123;&#123;student_name&#125;&#125;</span>
                </label>
                <textarea name="content" id="contentEditor" rows="12"
                          class="textarea textarea-bordered font-mono text-sm leading-relaxed @error('content') textarea-error @enderror"
                          placeholder="Type your certificate content here…" required>{{ $template->content }}</textarea>
                @error('content')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="form-control mt-4">
                <label class="label">
                    <span class="label-text font-medium">Footer Text</span>
                    <span class="label-text-alt text-gray-400 text-xs">Printed at the bottom of the document</span>
                </label>
                <input type="text" name="footer" value="{{ $template->footer }}"
                       placeholder="e.g. This certificate is issued upon request of the party concerned."
                       class="input input-bordered">
            </div>
        </div>

        {{-- Section 3: Signatories --}}
        <div class="bg-white rounded-lg shadow-sm border border-base-200 p-6">
            <div class="flex items-center gap-2 mb-5">
                <i class="fi fi-rr-pen-nib text-accent text-lg"></i>
                <h2 class="font-semibold text-gray-700">Signatories</h2>
                <span class="text-xs text-gray-400 ml-1">— up to 3 signatories</span>
            </div>

            <div class="space-y-5">
                {{-- Signatory 1 --}}
                <div class="rounded-lg border border-base-200 p-4 bg-base-50">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">
                        <i class="fi fi-rr-user mr-1"></i> Primary Signatory (School Head)
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label py-1"><span class="label-text text-sm">Full Name</span></label>
                            <input type="text" name="signatory_name"
                                   value="{{ $template->signatory_name }}"
                                   placeholder="e.g. Juan Dela Cruz"
                                   class="input input-bordered input-sm">
                        </div>
                        <div class="form-control">
                            <label class="label py-1"><span class="label-text text-sm">Title / Position</span></label>
                            <input type="text" name="signatory_title"
                                   value="{{ $template->signatory_title }}"
                                   placeholder="e.g. School Principal"
                                   class="input input-bordered input-sm">
                        </div>
                    </div>
                </div>

                {{-- Signatory 2 --}}
                <div class="rounded-lg border border-base-200 p-4 bg-base-50">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">
                        <i class="fi fi-rr-user mr-1"></i> Class Adviser <span class="font-normal normal-case text-gray-400">(optional)</span>
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label py-1"><span class="label-text text-sm">Full Name</span></label>
                            <input type="text" name="signatory_name_2"
                                   value="{{ $template->signatory_name_2 }}"
                                   placeholder="e.g. Maria Santos"
                                   class="input input-bordered input-sm">
                        </div>
                        <div class="form-control">
                            <label class="label py-1"><span class="label-text text-sm">Title / Position</span></label>
                            <input type="text" name="signatory_title_2"
                                   value="{{ $template->signatory_title_2 ?? 'Class Adviser' }}"
                                   placeholder="Class Adviser"
                                   class="input input-bordered input-sm">
                        </div>
                    </div>
                </div>

                {{-- Signatory 3 --}}
                <div class="rounded-lg border border-base-200 p-4 bg-base-50">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">
                        <i class="fi fi-rr-user mr-1"></i> School Registrar <span class="font-normal normal-case text-gray-400">(optional)</span>
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label py-1"><span class="label-text text-sm">Full Name</span></label>
                            <input type="text" name="signatory_name_3"
                                   value="{{ $template->signatory_name_3 }}"
                                   placeholder="e.g. Ana Reyes"
                                   class="input input-bordered input-sm">
                        </div>
                        <div class="form-control">
                            <label class="label py-1"><span class="label-text text-sm">Title / Position</span></label>
                            <input type="text" name="signatory_title_3"
                                   value="{{ $template->signatory_title_3 ?? 'School Registrar' }}"
                                   placeholder="School Registrar"
                                   class="input input-bordered input-sm">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Submit Bar --}}
        <div class="flex flex-col sm:flex-row gap-3 sm:justify-end pb-4">
            <a href="{{ route('registrar.certificate-templates.index') }}"
               class="btn btn-ghost order-last sm:order-first">
                Cancel
            </a>
            <button type="submit" class="btn btn-accent gap-2">
                <i class="fi fi-rr-check"></i>
                Save Changes
            </button>
        </div>
    </form>

    @push('scripts')
    <script>
        function copyPlaceholder(placeholder) {
            const textarea = document.getElementById('contentEditor');
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const text = textarea.value;

            textarea.value = text.substring(0, start) + placeholder + text.substring(end);
            textarea.selectionStart = textarea.selectionEnd = start + placeholder.length;
            textarea.focus();

            // Brief visual feedback
            const btn = event.currentTarget;
            const original = btn.innerHTML;
            btn.innerHTML = '<i class="fi fi-rr-check text-success text-xs"></i><span class="text-xs text-success">Inserted!</span>';
            setTimeout(() => btn.innerHTML = original, 1000);
        }
    </script>
    @endpush
</x-dashboard.registrar.base>
