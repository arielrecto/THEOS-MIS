<x-app-layout>
    <div class="w-full min-h-screen">
        <x-landing-page.navbar/>
        {{$slot}}
        <x-landing-page.footer/>
    </div>
</x-app-layout>
