@props([
    'announcements' => []
])

<!-- Hero Section -->
<section class="flex justify-center items-center py-20 min-h-screen text-center text-white bg-gradient-to-br from-accent to-accent-focus">
    <div class="container mx-auto px-4">
        <img src="{{ asset('logo-modified.png') }}" alt="Saint Therese Academy Logo" class="w-32 h-32 mx-auto mb-8">
        <h1 class="text-5xl font-bold mb-4">Saint Therese Academy</h1>
        <p class="text-xl mb-6">Excellence in Education, Guided by Faith</p>
        <p class="max-w-2xl mx-auto text-lg mb-8">
            Nurturing young minds through quality Catholic education since 1995
        </p>
        <a href="#admission" class="btn btn-lg btn-primary bg-white text-accent hover:bg-gray-100">
            <i class="fi fi-rr-graduation-cap mr-2"></i>
            Enroll Now
        </a>
    </div>
</section>

<!-- About Section -->
<section class="container px-6 mx-auto my-16">
    <div class="text-center max-w-4xl mx-auto">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Our Mission</h2>
        <p class="text-lg text-gray-700 mb-8">
            Saint Therese Academy is committed to providing holistic education that nurtures academic excellence,
            moral values, and spiritual growth in a supportive Catholic environment.
        </p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
            <div class="p-6 bg-white rounded-lg shadow-lg">
                <i class="fi fi-rr-book-open-cover text-4xl text-accent mb-4"></i>
                <h3 class="text-xl font-bold mb-3">Academic Excellence</h3>
                <p class="text-gray-600">Comprehensive curriculum focused on developing critical thinking and lifelong learning</p>
            </div>
            <div class="p-6 bg-white rounded-lg shadow-lg">
                <i class="fi fi-rr-heart text-4xl text-accent mb-4"></i>
                <h3 class="text-xl font-bold mb-3">Christian Values</h3>
                <p class="text-gray-600">Formation of character guided by Catholic teachings and moral principles</p>
            </div>
            <div class="p-6 bg-white rounded-lg shadow-lg">
                <i class="fi fi-rr-users text-4xl text-accent mb-4"></i>
                <h3 class="text-xl font-bold mb-3">Community Spirit</h3>
                <p class="text-gray-600">Fostering a supportive environment where students grow together in faith and learning</p>
            </div>
        </div>
    </div>
</section>

<!-- Programs Section -->
<section class="bg-gray-50 py-16">
    <div class="container px-6 mx-auto">
        <h2 class="text-3xl font-bold text-center mb-12">Academic Programs</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden group hover:shadow-xl transition-all">
                <div class="h-48 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=800&auto=format&fit=crop"
                         alt="Elementary Education"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-accent/20"></div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 text-gray-800">
                        <i class="fi fi-rr-graduation-cap text-accent mr-2"></i>
                        Elementary Education
                    </h3>
                    <ul class="space-y-2 text-gray-600">
                        <li>• Strong foundation in core subjects</li>
                        <li>• Character formation programs</li>
                        <li>• Engaging learning activities</li>
                        <li>• Regular spiritual guidance</li>
                    </ul>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg overflow-hidden group hover:shadow-xl transition-all">
                <div class="h-48 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?w=800&auto=format&fit=crop"
                         alt="Junior High School"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-accent/20"></div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 text-gray-800">
                        <i class="fi fi-rr-book-open-cover text-accent mr-2"></i>
                        Junior High School
                    </h3>
                    <ul class="space-y-2 text-gray-600">
                        <li>• Advanced academic curriculum</li>
                        <li>• Technology integration</li>
                        <li>• Leadership development</li>
                        <li>• Sports and arts programs</li>
                    </ul>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg overflow-hidden group hover:shadow-xl transition-all">
                <div class="h-48 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?w=800&auto=format&fit=crop"
                         alt="Senior High School"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-accent/20"></div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 text-gray-800">
                        <i class="fi fi-rr-diploma text-accent mr-2"></i>
                        Senior High School
                    </h3>
                    <ul class="space-y-2 text-gray-600">
                        <li>• College preparation</li>
                        <li>• Career guidance</li>
                        <li>• Research programs</li>
                        <li>• Community service</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Admission Section -->
<section id="admission" class="container px-6 mx-auto my-16 text-center">
     <h2 class="mb-6 text-3xl font-bold">Pendaftaran Siswa Baru</h2>
     <p class="mx-auto max-w-2xl text-gray-700">Bergabunglah dengan kami dan jadilah bagian dari komunitas pendidikan
         yang unggul.</p>
     <a href="#" class="inline-block px-6 py-3 mt-6 font-bold text-white bg-blue-600 rounded-lg">DAFTAR
         SEKARANG</a>
 </section>

<!-- Announcements Section -->
<section id="announcement" class="container px-6 mx-auto my-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-accent flex items-center justify-center gap-3">
            <i class="fi fi-rr-megaphone"></i>
            <span>Latest Announcements</span>
        </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($announcements as $announcement)
            <div class="bg-white rounded-lg shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow">
                <img src="{{ $announcement->image ?? asset('images/announcement-default.jpg') }}"
                     alt="Announcement Image"
                     class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $announcement->title }}</h3>
                    <p class="text-sm text-gray-500 mb-3">
                        <i class="fi fi-rr-calendar mr-1"></i>
                        {{ $announcement->created_at->format('F j, Y') }}
                    </p>
                    <p class="text-gray-600 line-clamp-3 mb-4">
                        {{ $announcement->description }}
                    </p>
                    <div class="text-right">
                        <a href="#" class="inline-flex items-center text-accent hover:text-accent-focus font-medium">
                            Read More
                            <i class="fi fi-rr-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3">
                <div class="flex items-center justify-center h-40 bg-gray-50 rounded-lg">
                    <p class="text-gray-500">
                        <i class="fi fi-rr-info-circle mr-2"></i>
                        No announcements available at the moment
                    </p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $announcements->links() }}
    </div>
</section>

<!-- Contact Section -->
<section class="bg-gray-50 py-16">
    <div class="container px-6 mx-auto text-center">
        <h2 class="text-3xl font-bold mb-8">Contact Us</h2>
        <div class="max-w-2xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="p-6 bg-white rounded-lg shadow-lg">
                    <i class="fi fi-rr-marker text-3xl text-accent mb-4"></i>
                    <h3 class="text-lg font-bold mb-2">Address</h3>
                    <p class="text-gray-600">Daang Amaya III, Tanza, Cavite</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-lg">
                    <i class="fi fi-rr-phone-call text-3xl text-accent mb-4"></i>
                    <h3 class="text-lg font-bold mb-2">Contact Information</h3>
                    <p class="text-gray-600">Phone: (046) 123-4567</p>
                    <p class="text-gray-600">Email: info@sta.edu.ph</p>
                </div>
            </div>
        </div>
    </div>
</section>
