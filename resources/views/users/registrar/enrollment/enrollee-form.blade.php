<x-dashboard.registrar.base>
    <x-dashboard.page-title
        :title="__('Enrollee Details')"
        :back_url="route('registrar.enrollments.index')"
    >
        <x-slot name="other">
            @if ($enrollee->status == 'pending')
                <form action="{{ route('registrar.enrollments.enrolled', $enrollee->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-sm btn-accent">Enrolled</button>
                </form>
            @endif


        </x-slot>
    </x-dashboard.page-title>
    <x-notification-message />
                <p class="mb-4">
                    <strong>Status:</strong> <span class="font-bold text-accent">{{ $enrollee->status }}</span>
                </p>
                <!-- School Year and Grade Level -->
                <div class="mb-4">
                    <p><strong>School Year:</strong> {{ $enrollee->school_year }}</p>
                    <p><strong>Grade Level:</strong> {{ $enrollee->grade_level }}</p>
                    <p><strong>Returning Learner:</strong> {{ $enrollee->balik_aral ? 'Yes' : 'No' }}</p>
                </div>

                <!-- Learner Information -->
                <h2 class="mb-2 text-lg font-bold">Learner Information</h2>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <p><strong>Name:</strong> {{ $enrollee->first_name }} {{ $enrollee->middle_name }} {{ $enrollee->last_name }} {{ $enrollee->extension_name }}</p>
                    <p><strong>Birthdate:</strong> {{ $enrollee->birthdate }}</p>
                    <p><strong>Birthplace:</strong> {{ $enrollee->birthplace }}</p>
                </div>

                <!-- Address -->
                <h2 class="mb-2 text-lg font-bold">Current Address</h2>
                <p>{{ $enrollee->house_no }} {{ $enrollee->street }}, {{ $enrollee->barangay }}, {{ $enrollee->city }}, {{ $enrollee->province }}, {{ $enrollee->zip_code }}</p>

                <h2 class="mt-4 text-lg font-bold">Permanent Address</h2>
                <p>{{ $enrollee->perm_house_no }} {{ $enrollee->perm_street }}, {{ $enrollee->perm_barangay }}, {{ $enrollee->perm_city }}, {{ $enrollee->perm_province }}, {{ $enrollee->perm_zip_code }}</p>

                <!-- Parent/Guardian Information -->
                <h2 class="mt-4 text-lg font-bold">Parent/Guardian Information</h2>
                <p><strong>Name:</strong> {{ $enrollee->parent_name }}</p>
                <p><strong>Relationship:</strong> {{ $enrollee->relationship }}</p>
                <p><strong>Contact Number:</strong> {{ $enrollee->contact_number }}</p>
                <p><strong>Occupation:</strong> {{ $enrollee->occupation }}</p>

                <!-- SHS Preferences -->
                <h2 class="mt-4 text-lg font-bold">Senior High School Preferences</h2>
                <p><strong>Track:</strong> {{ $enrollee->preferred_track }}</p>
                <p><strong>Strand:</strong> {{ $enrollee->preferred_strand }}</p>

                <!-- Distance Learning Modalities -->
                <h2 class="mt-4 text-lg font-bold">Preferred Distance Learning Modality</h2>
                <ul>


                    @foreach( $enrollee->modality ?? [] as $modality)
                        <li>{{ ucfirst($modality) }}</li>
                    @endforeach
                </ul>

                <h2 class="mt-4 text-lg font-bold">Email</h2>
                <p>{{ $enrollee->email ?? 'N/A' }}</p>

                <div class="mt-6">
                    <a href="{{ route('registrar.enrollments.index') }}" class="btn btn-secondary">Back to List</a>
                </div>



</x-dashboard.registrar.base>