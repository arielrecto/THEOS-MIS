<x-landing-page.base>
    <section class="container px-6 mx-auto my-16 text-center">
        <h2 class="mb-6 text-3xl font-bold">{{ $aboutUs->title ?? 'About Our School' }}</h2>
        <p class="mx-auto max-w-2xl text-gray-700">{{ $aboutUs->sub_title ?? 'We are committed to providing the best education with modern facilities and professional teachers.' }}</p>

        <div class="flex flex-col gap-10 items-center md:flex-row mt-10">
            <div class="w-full md:w-1/2">
                @if($aboutUs?->path)
                    <img src="{{ Storage::url($aboutUs->path) }}"
                         alt="School Building"
                         class="w-full rounded-lg shadow-lg object-cover"
                         onerror="this.src='https://media.istockphoto.com/id/171306436/photo/red-brick-high-school-building-exterior.jpg?s=612x612&w=0&k=20&c=vksDyCVrfCpvb9uk4-wcBYu6jbTZ3nCOkGHPSgNy-L0='">
                @else
                    <img src="https://media.istockphoto.com/id/171306436/photo/red-brick-high-school-building-exterior.jpg?s=612x612&w=0&k=20&c=vksDyCVrfCpvb9uk4-wcBYu6jbTZ3nCOkGHPSgNy-L0="
                         alt="School Building"
                         class="w-full rounded-lg shadow-lg">
                @endif
            </div>
            <div class="w-full md:w-1/2">
                <div class="prose prose-lg max-w-none">
                    {!! nl2br(e($aboutUs->description ?? '
                        Welcome to <span class="font-bold text-accent">Theos Higher Ground Academe</span>, where we nurture
                        young minds and foster a passion for learning. Our institution is committed to providing quality
                        education through innovative teaching methods and a supportive environment.

                        We believe in holistic development, encouraging students to excel academically while participating in
                        extracurricular activities. Our mission is to shape future leaders equipped with knowledge, critical
                        thinking skills, and strong moral values.
                    ')) !!}
                </div>
            </div>
        </div>

        <div class="mt-10 text-center">
            <h2 class="text-3xl font-bold text-accent">Our Vision & Mission</h2>
            <div class="prose prose-lg max-w-3xl mx-auto mt-4">
                {!! nl2br(e($aboutUs->mission_and_vision ?? '
                    Our vision is to be a leading educational institution that inspires and empowers students to achieve
                    excellence. Our mission is to cultivate a dynamic learning environment that fosters intellectual growth,
                    creativity, and social responsibility.
                ')) !!}
            </div>
        </div>
    </section>
</x-landing-page.base>
