{{-- Shared page canvas for every portal: school wallpaper fills the whole area under the navbar, footer at the bottom --}}
<div {{ $attributes->merge(['class' => 'flex flex-col flex-1 gap-6 p-4 bg-top bg-cover sm:p-6 lg:gap-8 lg:p-8']) }}
    style="background-image: url('{{ asset(config('school.dashboard_background')) }}')">
    <div class="main">
        {{ $slot }}
    </div>

    <x-dashboard.footer class="mt-auto" />
</div>
