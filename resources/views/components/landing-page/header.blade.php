@props([
    'announcements' => []
])

<!-- Hero Section -->
 <section class="flex justify-center items-center py-20 min-h-screen text-center text-white bg-blue-500">
     <div class="container mx-auto">
         <h1 class="text-5xl font-bold">Selamat Datang di Sekolah Kami</h1>
         <p class="mt-4 text-lg">Membangun Masa Depan dengan Pendidikan Berkualitas</p>
         <a href="#admission" class="inline-block px-6 py-3 mt-6 font-bold text-blue-600 bg-white rounded-lg">DAFTAR
             SEKARANG</a>
     </div>
 </section>

 <!-- About Section -->
 <section class="container px-6 mx-auto my-16 text-center">
     <h2 class="mb-6 text-3xl font-bold">Tentang Sekolah Kami</h2>
     <p class="mx-auto max-w-2xl text-gray-700">Kami berkomitmen untuk memberikan pendidikan terbaik dengan fasilitas
         modern dan tenaga pengajar profesional.</p>
 </section>

 <!-- Programs Section -->
 <section class="flex justify-center items-center py-16 min-h-screen bg-gray-200">
     <div class="container px-6 mx-auto text-center">
         <h2 class="mb-6 text-3xl font-bold">Program Pendidikan</h2>
         <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
             <div class="p-6 bg-white rounded-lg shadow-lg">
                 <h3 class="text-xl font-bold">SD</h3>
                 <p class="mt-4 text-gray-600">Pendidikan dasar yang membangun karakter dan keterampilan anak.</p>
             </div>
             <div class="p-6 bg-white rounded-lg shadow-lg">
                 <h3 class="text-xl font-bold">SMP</h3>
                 <p class="mt-4 text-gray-600">Menanamkan pengetahuan dan keterampilan untuk masa depan.</p>
             </div>
             <div class="p-6 bg-white rounded-lg shadow-lg">
                 <h3 class="text-xl font-bold">SMA</h3>
                 <p class="mt-4 text-gray-600">Persiapan akademik dan keterampilan menuju jenjang yang lebih tinggi.</p>
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

 <section id="announcement" class="container px-6 mx-auto my-16 text-center">
    <h2 class="flex gap-3 justify-center items-center mb-6 text-3xl font-bold text-blue-600">
        <i class="fi fi-rr-megaphone"></i>
        <span>Announcements</span>
    </h2>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($announcements as $announcement)
            <div class="overflow-hidden bg-white rounded-lg border border-gray-200 shadow-lg">
                <img src="{{ $announcement->image ?? asset('images2.jpg') }}" alt="Announcement Image" class="object-cover w-full h-40">
                <div class="p-4 text-left">
                    <h3 class="text-xl font-bold text-blue-600">{{ $announcement->title }}</h3>
                    <p class="text-sm text-gray-500">Posted on: {{ $announcement->created_at->format('F j, Y') }}</p>
                    <p class="mt-2 text-sm text-gray-700 line-clamp-3">
                        {{ $announcement->description }}
                    </p>
                    <div class="mt-4 text-right">
                        <a href="#" class="font-semibold text-blue-600 hover:underline">Read More</a>
                    </div>
                </div>
            </div>
        @empty
        <div class="flex col-span-3 justify-center items-center w-full h-40 bg-gray-200 rounded-lg shadow-lg">
            <p class="text-lg text-gray-700"><i class="fi fi-rr-megaphone text-accent"></i> No announcements available.</p>
        </div>
        @endforelse
    </div>
    {{ $announcements->links() }}
</section>

 <!-- Contact Section -->
 <section class="py-16 bg-gray-200">
     <div class="container px-6 mx-auto text-center">
         <h2 class="mb-6 text-3xl font-bold">Hubungi Kami</h2>
         <p class="mx-auto max-w-2xl text-gray-700">Untuk informasi lebih lanjut, silakan hubungi kami.</p>
         <p class="mt-4 text-lg font-bold">Email: info@sekolah.com | Telepon: +62 812-3456-7890</p>
     </div>
 </section>
