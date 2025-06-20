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
{{ $courses->withQueryString()->links() }}