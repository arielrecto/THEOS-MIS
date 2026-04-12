<x-dashboard.registrar.base>
    <x-dashboard.page-title :title="_('Certificate Templates')" />
    <x-notification-message />

    <div class="p-4 sm:p-6 bg-white rounded-lg shadow-lg">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-700">
                Manage Certificate Templates
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Edit certificate templates to customize the content. Use placeholders to insert dynamic student data.
            </p>
        </div>

        <!-- Templates List -->
        <div class="grid grid-cols-1 gap-4">
            @forelse($templates as $template)
                <div class="card bg-base-100 border border-base-300 shadow-sm hover:shadow-md transition-shadow">
                    <div class="card-body">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="card-title text-base sm:text-lg">
                                    {{ $template->name }}
                                    @if($template->is_active)
                                        <span class="badge badge-success badge-sm">Active</span>
                                    @else
                                        <span class="badge badge-ghost badge-sm">Inactive</span>
                                    @endif
                                </h3>
                                <p class="text-xs sm:text-sm text-gray-500 mt-2">
                                    <strong>Type:</strong> {{ ucwords(str_replace('_', ' ', $template->type)) }}
                                </p>
                                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                                    <strong>Title:</strong> {{ $template->title }}
                                </p>
                                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                                    <strong>Signatory:</strong> {{ $template->signatory_name }} - {{ $template->signatory_title }}
                                </p>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('registrar.certificate-templates.edit', $template) }}"
                                   class="btn btn-sm btn-accent">
                                    <i class="fi fi-rr-edit"></i>
                                    <span class="hidden sm:inline ml-1">Edit</span>
                                </a>
                            </div>
                        </div>

                        <!-- Content Preview -->
                        <div class="mt-4 p-4 bg-base-200 rounded-lg">
                            <p class="text-xs font-semibold text-gray-600 mb-2">Content Preview:</p>
                            <div class="text-xs sm:text-sm text-gray-700 line-clamp-3">
                                {{ Str::limit(strip_tags($template->content), 200) }}
                            </div>
                        </div>

                        <!-- Last Updated -->
                        <div class="mt-2 text-xs text-gray-400">
                            Last updated: {{ $template->updated_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-base-100 rounded-lg border-2 border-dashed border-base-300">
                    <div class="text-4xl mb-4 text-gray-400">
                        <i class="fi fi-rr-document"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No Templates Found</h3>
                    <p class="text-sm text-gray-500 mt-2">
                        No certificate templates have been created yet.
                    </p>
                </div>
            @endforelse
        </div>

        <!-- Info Box -->
        <div class="mt-6 alert alert-info">
            <div>
                <i class="fi fi-rr-info mr-2"></i>
                <div>
                    <h3 class="font-bold">About Certificate Templates</h3>
                    <div class="text-xs mt-1">
                        Certificate templates allow you to customize the content of certificates without affecting the dynamic data rendering.
                        Use placeholders like <code class="bg-base-200 px-1 rounded">@{{student_name}}</code> to insert student information automatically.
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.registrar.base>
