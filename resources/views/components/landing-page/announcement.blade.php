<section id="announcement" class="container px-6 mx-auto my-16 text-center">
    <h2 class="flex gap-3 justify-center items-center mb-6 text-3xl font-bold text-blue-600">
        <i class="fi fi-rr-megaphone"></i>
        <span>Announcements</span>
    </h2>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        @for ($i = 0; $i < 5; $i++)
            <div class="overflow-hidden bg-white rounded-lg border border-gray-200 shadow-lg">
                <img src="{{ asset('images2.jpg') }}" alt="Announcement Image" class="object-cover w-full h-40">
                <div class="p-4 text-left">
                    <h3 class="text-xl font-bold text-blue-600">Heat Strike</h3>
                    <p class="text-sm text-gray-500">Posted on: 4/17/2024</p>
                    <p class="mt-2 text-sm text-gray-700 line-clamp-3">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi a lacinia lacus. Nulla varius
                        purus tincidunt nulla mollis convallis.
                    </p>
                    <div class="mt-4 text-right">
                        <a href="#" class="font-semibold text-blue-600 hover:underline">Read More</a>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</section>