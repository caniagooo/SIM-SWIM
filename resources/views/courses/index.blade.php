
<x-default-layout>
    <div class="container mt-0 mb-4">
        <!-- Header Card -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 p-4">
                <div>
                    <h4 class="mb-1 fw-bold text-gray-900">Manajemen Kursus</h4>
                    <div class="d-flex flex-wrap gap-2 small mb-1">
                        <span class="badge badge-light-info fw-semibold">
                            <i class="bi bi-journal-bookmark me-1"></i> Total: {{ $courses->count() }} Kursus
                        </span>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <!-- Status Filter Dropdown -->
                    <div class="dropdown mb-2 mb-md-0">
                        <button class="btn btn-light-primary btn-sm dropdown-toggle d-flex align-items-center shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-filter me-1"></i>
                            <span class="fw-semibold">{{ $statusLabel }}</span>
                            <span class="badge {{ $statusBadgeClass }} ms-2 px-2 py-1 rounded-pill">{{ $statusCount }}</span>
                        </button>
                        <ul class="dropdown-menu shadow-sm">
                            <li>
                                <a class="dropdown-item d-flex justify-content-between align-items-center status-filter-link {{ !request('status') ? 'active fw-bold' : '' }}"
                                   href="{{ route('courses.index', request()->except('status')) }}">
                                    Total
                                    <span class="badge bg-primary text-white ms-2 px-2 py-1 rounded-pill">{{ $countTotal }}</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex justify-content-between align-items-center status-filter-link {{ request('status') == 'active' ? 'active fw-bold' : '' }}"
                                   href="{{ route('courses.index', array_merge(request()->except('status'), ['status' => 'active'])) }}">
                                    Aktif
                                    <span class="badge bg-success text-white ms-2 px-2 py-1 rounded-pill">{{ $countActive }}</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex justify-content-between align-items-center status-filter-link {{ request('status') == 'expired' ? 'active fw-bold' : '' }}"
                                   href="{{ route('courses.index', array_merge(request()->except('status'), ['status' => 'expired'])) }}">
                                    Expired
                                    <span class="badge bg-danger text-white ms-2 px-2 py-1 rounded-pill">{{ $countExpired }}</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex justify-content-between align-items-center status-filter-link {{ request('status') == 'unpaid' ? 'active fw-bold' : '' }}"
                                   href="{{ route('courses.index', array_merge(request()->except('status'), ['status' => 'unpaid'])) }}">
                                    Unpaid
                                    <span class="badge bg-warning text-dark ms-2 px-2 py-1 rounded-pill">{{ $countUnpaid }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    @if(request('status'))
                        <a href="{{ route('courses.index', request()->except('status')) }}"
                           class="btn btn-light btn-sm border ms-1 shadow-sm" title="Clear Selection">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    @endif

                    <!-- Advanced Filter Dropdown -->
                    <div class="dropdown ms-0 ms-md-3 mt-2 mt-md-0">
                        <button class="btn btn-light-primary btn-sm shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-funnel-fill me-1"></i> Filter
                        </button>
                        <div class="dropdown-menu p-4 shadow-lg" style="min-width:320px;">
                            <form method="GET" id="advancedFilterForm">
                                @if(request('status'))
                                    <input type="hidden" name="status" value="{{ request('status') }}">
                                @endif
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
                                        @foreach($uniqueVenues as $venue)
                                            <option value="{{ $venue->id }}" {{ request('venue_id') == $venue->id ? 'selected' : '' }}>
                                                {{ $venue->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary fw-bold flex-fill shadow-sm">Terapkan</button>
                                    <a href="{{ route('courses.index') }}" class="btn btn-light fw-bold flex-fill shadow-sm">Reset</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <a href="{{ route('courses.create') }}" class="btn btn-primary btn-sm mt-2 mt-md-0 shadow-sm">
                        <i class="bi bi-plus-circle"></i> Tambah Kursus
                    </a>
                </div>
            </div>
        </div>
       

        <!-- Course List -->
        <div id="courseList">
            @include('courses.partials.course-list', ['cards' => $cards])
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-6" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    {{-- Modal Assign Trainer & Materials --}}
    @foreach ($courses as $course)
        @include('courses.partials.assign-trainer-modal', ['course' => $course, 'allTrainers' => $allTrainers])
        @include('courses.partials.assign-materials-modal', ['course' => $course, 'allMaterials' => $allMaterials])
    @endforeach

    {{-- Modal Sessions: gunakan data dari $cards --}}
    @foreach ($cards as $card)
        @include('courses.partials.sessions-modal', [
            'course' => $card['course'],
            'sessions' => $card['sessions'],
        ])
    @endforeach

    @include('courses.partials.invoice-course-modal')
</x-default-layout>

