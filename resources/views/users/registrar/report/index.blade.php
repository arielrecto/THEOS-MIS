<x-dashboard.registrar.base>
    <x-dashboard.page-title :title="_('Reports')" />

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

        {{-- Enrollment Report --}}
        <div class="bg-base-100 rounded-lg shadow-lg p-6 flex flex-col">
            <div class="flex items-start gap-4 mb-4">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-accent/10 shrink-0">
                    <i class="fi fi-rr-users text-2xl text-accent"></i>
                </div>
                <div>
                    <h2 class="text-base font-bold text-gray-800">Enrollment Report</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Enrollee list per academic year with status breakdown</p>
                </div>
            </div>
            <ul class="space-y-1.5 text-sm text-gray-600 mb-6 flex-1">
                <li class="flex items-center gap-2"><i class="fi fi-rr-check text-success"></i> Enrollee information</li>
                <li class="flex items-center gap-2"><i class="fi fi-rr-check text-success"></i> Grade level breakdown</li>
                <li class="flex items-center gap-2"><i class="fi fi-rr-check text-success"></i> Approval status summary</li>
                <li class="flex items-center gap-2"><i class="fi fi-rr-check text-success"></i> Signed by Registrar &amp; Admin</li>
            </ul>
            <a href="{{ route('registrar.reports.enrollment') }}" class="btn btn-accent w-full gap-2 text-white">
                <i class="fi fi-rr-file-chart-line"></i> Generate Report
            </a>
        </div>

        {{-- Payment Report --}}
        <div class="bg-base-100 rounded-lg shadow-lg p-6 flex flex-col">
            <div class="flex items-start gap-4 mb-4">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-success/10 shrink-0">
                    <i class="fi fi-rr-sack-dollar text-2xl text-success"></i>
                </div>
                <div>
                    <h2 class="text-base font-bold text-gray-800">Payment Report</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Payment transactions made by enrollees per academic year</p>
                </div>
            </div>
            <ul class="space-y-1.5 text-sm text-gray-600 mb-6 flex-1">
                <li class="flex items-center gap-2"><i class="fi fi-rr-check text-success"></i> Payment amounts &amp; methods</li>
                <li class="flex items-center gap-2"><i class="fi fi-rr-check text-success"></i> Per-student breakdown</li>
                <li class="flex items-center gap-2"><i class="fi fi-rr-check text-success"></i> Approved &amp; pending totals</li>
                <li class="flex items-center gap-2"><i class="fi fi-rr-check text-success"></i> Signed by Registrar &amp; Admin</li>
            </ul>
            <a href="{{ route('registrar.reports.payment') }}" class="btn btn-success w-full gap-2 text-white">
                <i class="fi fi-rr-file-chart-line"></i> Generate Report
            </a>
        </div>

    </div>
</x-dashboard.registrar.base>
