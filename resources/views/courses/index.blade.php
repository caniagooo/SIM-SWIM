<x-default-layout>
    <div class="container">
        <!-- Header -->
        <div class="d-flex flex-wrap flex-stack mb-6">
            <div class="d-flex align-items-center">
                <h1 class="fw-bold mb-0 me-4">Courses</h1>
                <span class="badge badge-light-primary fs-7 me-2 py-2 px-3" style="font-size:0.95rem;">
                    Total <span class="fw-bold ms-1">{{ $courses->count() }}</span>
                </span>
                <a href="?status=active" class="badge badge-light-success fs-7 me-1 py-2 px-3 {{ request('status') == 'active' ? 'border border-success' : '' }}" style="font-size:0.95rem; cursor:pointer;">
                    Aktif <span class="fw-bold ms-1">
                        {{ $courses->filter(fn($c) => optional($c->payment)->status === 'paid' && now()->lte($c->valid_until) && (!$c->max_sessions || $c->sessions->where('status','completed')->count() < $c->max_sessions))->count() }}
                    </span>
                </a>
                <a href="?status=expired" class="badge badge-light-danger fs-7 me-1 py-2 px-3 {{ request('status') == 'expired' ? 'border border-danger' : '' }}" style="font-size:0.95rem; cursor:pointer;">
                    Expired <span class="fw-bold ms-1">
                        {{ $courses->filter(fn($c) => optional($c->payment)->status === 'paid' && (now()->gt($c->valid_until) || ($c->max_sessions && $c->sessions->where('status','completed')->count() >= $c->max_sessions)))->count() }}
                    </span>
                </a>
                <a href="?status=unpaid" class="badge badge-light-warning fs-7 py-2 px-3 {{ request('status') == 'unpaid' ? 'border border-warning' : '' }}" style="font-size:0.95rem; cursor:pointer;">
                    Unpaid <span class="fw-bold ms-1">
                        {{ $courses->filter(fn($c) => optional($c->payment)->status === 'pending')->count() }}
                    </span>
                </a>
                <!-- Advanced Filter Dropdown -->
                <div class="dropdown ms-3">
                    <button class="btn btn-light-primary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-funnel-fill me-1"></i> Filter Lanjutan
                    </button>
                    <div class="dropdown-menu p-4 shadow-lg" style="min-width:320px;">
                        <form method="GET" id="advancedFilterForm">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Pelatih</label>
                                <select name="trainer_id" class="form-select">
                                    <option value="">Semua Pelatih</option>
                                    @foreach($allTrainers as $trainer)
                                        <option value="{{ $trainer->id }}" {{ request('trainer_id') == $trainer->id ? 'selected' : '' }}>
                                            {{ $trainer->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Venue</label>
                                <select name="venue_id" class="form-select">
                                    <option value="">Semua Venue</option>
                                    @foreach($courses->pluck('venue')->unique('id')->filter() as $venue)
                                        <option value="{{ $venue->id }}" {{ request('venue_id') == $venue->id ? 'selected' : '' }}>
                                            {{ $venue->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary fw-bold flex-fill">Terapkan</button>
                                <a href="{{ route('courses.index') }}" class="btn btn-light fw-bold flex-fill">Reset</a>
                            </div>
                        </form>
                    </div>
                </div>
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

    @include('courses.partials.invoice-course-modal')
</x-default-layout>