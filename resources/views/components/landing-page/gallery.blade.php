<x-landing-page.base>

    <section class="container px-6 mx-auto my-16 text-center">
        <h2 class="mb-6 text-3xl font-bold">Gallery</h2>
        <p class="mx-auto max-w-2xl text-gray-700">Explore our gallery of moments and achievements.</p>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @for ($i = 1; $i <= 8; $i++)
                <div class="overflow-hidden relative rounded-lg shadow-lg group">
                    <img src="https://media.istockphoto.com/id/171306436/photo/red-brick-high-school-building-exterior.jpg?s=612x612&w=0&k=20&c=vksDyCVrfCpvb9uk4-wcBYu6jbTZ3nCOkGHPSgNy-L0=" alt="Gallery Image {{ $i }}" class="object-cover w-full h-60">
                    <div class="flex absolute inset-0 justify-center items-center bg-black bg-opacity-50 opacity-0 transition duration-300 group-hover:opacity-100">
                        <p class="text-lg font-bold text-white">Image {{ $i }}</p>
                    </div>
                </div>
            @endfor
        </div>
    </section>

</x-landing-page.base>