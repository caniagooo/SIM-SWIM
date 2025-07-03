<div class="row g-8">
    @foreach($cards as $card)
        @include('courses.partials.course-card', $card)
    @endforeach
</div>

<div class="d-flex justify-content-center mt-4">
    <nav>
        {{ $courses->withQueryString()->links('vendor.pagination.bootstrap-5') }}
    </nav>
</div>

    @foreach ($courses as $course)
        @include('courses.partials.assign-trainer-modal', ['course' => $course, 'allTrainers' => $allTrainers])
        @include('courses.partials.assign-materials-modal', ['course' => $course, 'allMaterials' => $allMaterials])
        @include('courses.partials.sessions-modal', ['course' => $course])
    @endforeach

    @include('courses.partials.invoice-course-modal')