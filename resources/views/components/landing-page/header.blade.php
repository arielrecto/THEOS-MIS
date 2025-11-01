@props([
    'announcements' => [],
    'programs' => [],
])

@php
    use App\Models\Logo;
    use App\Models\Enrollment;
    use App\Enums\EnrollmentStatus;
    use App\Models\AboutUs;
    use Illuminate\Support\Facades\Storage;

    $mainLogo = Logo::where('type', 'main')->where('is_active', true)->latest()->first();

    $logoPath = $mainLogo ? Storage::url($mainLogo->path) : asset('logo.jpg');

    $activeEnrollment = Enrollment::where('status', EnrollmentStatus::ONGOING)->latest()->first();

    $aboutUs = AboutUs::first();
    $a = $aboutUs ? $aboutUs->address : 'set address in the admin panel';
@endphp

<!-- Hero Section - Updated for better impact -->
<section
    class="relative flex justify-center items-center min-h-screen text-white bg-gradient-to-br from-accent to-accent-focus overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -right-10 -top-10 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -left-10 -bottom-10 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
    </div>

    <div class="container relative mx-auto px-4 py-20 text-center">
        <div class="animate-fade-in">
            <img src="{{ $logoPath }}" alt="School Logo"
                class="w-32 h-32 mx-auto mb-8 rounded-full object-contain shadow-lg border-4 border-white/20"
                onerror="this.src='{{ asset('logo.jpg') }}'">

            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                Excellence in Education,<br>Guided by Faith
            </h1>

            <p class="max-w-2xl mx-auto text-lg md:text-xl mb-12 text-white/90">
                Nurturing young minds through quality Christian education since 1997.
            </p>

            @if ($activeEnrollment)
                <a href="{{ route('enrollment.show', ['id' => $activeEnrollment->id]) }}"
                    class="inline-flex items-center btn btn-lg btn-primary bg-white text-accent hover:bg-gray-100 hover:scale-105 transform transition-all duration-300 shadow-lg">
                    <i class="fi fi-rr-graduation-cap mr-2"></i>
                    Enroll Now
                    <span class="ml-2 badge badge-accent">Open</span>
                </a>
            @else
                <button disabled class="btn btn-lg bg-gray-200/20 text-white/60 cursor-not-allowed backdrop-blur-sm">
                    <i class="fi fi-rr-graduation-cap mr-2"></i>
                    Enrollment Closed
                </button>
            @endif
        </div>
    </div>
</section>

<!-- Core Values Section - Updated for better visualization -->
<section class="container px-4 mx-auto py-20">
    <div class="text-center max-w-4xl mx-auto">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">Core Values</h2>
        <p class="text-lg text-gray-700 mb-12 leading-relaxed">
            The Theos Higher Ground Academe is dedicated to producing vibrant students who are
            Spiritually, Physically, Intellectually, Emotionally and Socially committed to the fulfillment of
            the Culture of Righteousness and Academic Excellence.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="group p-8 bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="mb-6 transform transition-transform group-hover:scale-110">
                    <i class="fi fi-rr-book-open-cover text-5xl text-accent"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 text-gray-800">Academic Excellence</h3>
                <p class="text-gray-600 leading-relaxed">Comprehensive curriculum focused on developing critical
                    thinking and lifelong learning</p>
            </div>
            <div class="group p-8 bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="mb-6 transform transition-transform group-hover:scale-110">
                    <i class="fi fi-rr-heart text-5xl text-accent"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 text-gray-800">Christian Values</h3>
                <p class="text-gray-600 leading-relaxed">Formation of character guided by Christian teachings and moral
                    principles</p>
            </div>
            <div class="group p-8 bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                <div class="mb-6 transform transition-transform group-hover:scale-110">
                    <i class="fi fi-rr-users text-5xl text-accent"></i>
                </div>
                <h3 class="text-xl font-bold mb-4 text-gray-800">Community Spirit</h3>
                <p class="text-gray-600 leading-relaxed">Fostering a supportive environment where students grow together
                    in faith and learning</p>
            </div>
        </div>
    </div>
</section>

<!-- Academic Programs Section - Redesigned for better presentation -->
<section class="bg-gray-50 py-20">
    <div class="container px-4 mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Academic Programs</h2>
            <div class="w-24 h-1 bg-accent mx-auto"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($programs as $program)
                <div
                    class="bg-white rounded-xl shadow-lg overflow-hidden group hover:shadow-xl transition-all duration-300">
                    <div class="aspect-w-16 aspect-h-9 overflow-hidden relative">
                        <img src="{{ Storage::url($program->path) }}" alt="{{ $program->title }}"
                            class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-110"
                            onerror="this.src='https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=800&auto=format&fit=crop'">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <h3 class="text-xl font-bold text-white mb-2">{{ $program->title }}</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4 line-clamp-3">{{ $program->description }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-accent font-medium">Learn More</span>
                            <a href="{{ route('academic-programs.show', $program->id) }}" class="text-accent"><i
                                    class="fi fi-rr-arrow-right text-accent"></i></a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="flex flex-col items-center justify-center py-16 bg-white rounded-xl">
                        <i class="fi fi-rr-info-circle text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500">No academic programs available at the moment</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Admission Section -->
{{-- <section id="admission" class="container px-6 mx-auto my-16 text-center">
    <h2 class="mb-6 text-3xl font-bold">Pendaftaran Siswa Baru</h2>
    <p class="mx-auto max-w-2xl text-gray-700">Bergabunglah dengan kami dan jadilah bagian dari komunitas pendidikan
        yang unggul.</p>
    <a href="#" class="inline-block px-6 py-3 mt-6 font-bold text-white bg-blue-600 rounded-lg">DAFTAR
        SEKARANG</a>
</section> --}}

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
            <div
                class="bg-white rounded-lg shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow">
                <img src="{{ asset($announcement->image) }}" alt="Announcement Image" class="w-full h-48 object-cover">
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
                        <a href="{{ route('general-announcements.show', ['id' => $announcement->id]) }}"
                            class="inline-flex items-center text-accent hover:text-accent-focus font-medium">
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
                    <p class="text-gray-600">{{ $aboutUs->address ?? 'set up to admin' }}</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-lg">
                    <i class="fi fi-rr-phone-call text-3xl text-accent mb-4"></i>
                    <h3 class="text-lg font-bold mb-2">Contact Information</h3>
                    <p class="text-gray-600">Phone: 0917547 5374</p>
                    <p class="text-gray-600">Email: thgaofficial@gmail.com</p>
                </div>
            </div>
        </div>
    </div>
</section>
