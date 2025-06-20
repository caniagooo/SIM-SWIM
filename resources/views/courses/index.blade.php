<x-default-layout>
    <div class="container">
        <!-- Header -->
        <div class="d-flex flex-wrap flex-stack mb-6">
            <div class="d-flex align-items-center">
                <h1 class="fw-bold mb-0 me-4">Courses</h1>
                <span class="badge badge-light-primary fs-6">{{ $courses->count() }} Total</span>
            </div>
            <a href="{{ route('courses.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Course
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-6" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-8">
            @forelse ($courses as $course)
                @include('courses.partials.course-card', ['course' => $course])
            @empty
                <div class="col-12 text-center text-muted">
                    <div class="alert alert-info py-10">
                        <i class="bi bi-info-circle fs-2x mb-2"></i>
                        <div class="fs-5">No courses available.</div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    @foreach ($courses as $course)
        @include('courses.partials.assign-trainer-modal', ['course' => $course, 'allTrainers' => $allTrainers])
        @include('courses.partials.assign-materials-modal', ['course' => $course, 'allMaterials' => $allMaterials])
        @include('courses.partials.sessions-modal', ['course' => $course])
    @endforeach
    
</x-default-layout>