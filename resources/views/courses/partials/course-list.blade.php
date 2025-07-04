<div class="row g-8">
    @foreach($cards as $card)
        @include('courses.partials.course-card', $card)
    @endforeach
</div>

{{-- Pagination: hanya tampil jika variabel $pagination ada --}}
@if(isset($pagination) && $pagination instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="d-flex justify-content-center mt-4">
        <nav>
            {{ $pagination->withQueryString()->links('vendor.pagination.bootstrap-5') }}
        </nav>
    </div>
@endif

@foreach ($cards as $card)
    @include('courses.partials.assign-trainer-modal', ['course' => $card['course'], 'allTrainers' => $allTrainers])
    @include('courses.partials.assign-materials-modal', ['course' => $card['course'], 'allMaterials' => $allMaterials])
    @include('courses.partials.sessions-modal', [
        'course' => $card['course'],
        'sessions' => $card['sessions'] // <-- tambahkan ini!
    ])
@endforeach

@include('courses.partials.invoice-course-modal')