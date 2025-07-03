<x-default-layout>
<div class="container mt-0 mb-4">
    <form id="course-form" method="POST" action="{{ route('courses.update', $course->id) }}">
        @csrf
        @method('PUT')

        <div class="card card-flush">
            <div class="card-header align-items-center py-4 gap-2 gap-md-5 flex-column flex-md-row">
                <div class="card-title">
                    <h2 class="fw-bold mb-0 d-flex align-items-center">
                        <span class="svg-icon svg-icon-2 me-2 text-primary">
                            <i class="bi-book"></i>
                        </span>
                        Edit Kursus
                    </h2>
                </div>
                <div class="card-toolbar mt-2 mt-md-0">
                    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-light-primary btn-sm">
                        <span class="svg-icon svg-icon-2 me-1">
                            <i class="bi-arrow-left"></i>
                        </span>
                        Kembali ke Detail Kursus
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <ul class="nav nav-tabs nav-line-tabs mb-4 fs-6 flex-nowrap overflow-auto" id="progressTab" role="tablist" style="white-space:nowrap;">
                    <li class="nav-item">
                        <button class="nav-link active" id="step1-tab" data-bs-toggle="tab" data-bs-target="#step1" type="button" role="tab" aria-controls="step1" aria-selected="true">
                            Step 1: Detail Kursus
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="step2-tab" data-bs-toggle="tab" data-bs-target="#step2" type="button" role="tab" aria-controls="step2" aria-selected="false">
                            Step 2: Venue & Sesi
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="step3-tab" data-bs-toggle="tab" data-bs-target="#step3" type="button" role="tab" aria-controls="step3" aria-selected="false">
                            Step 3: Pelatih & Materi
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="progressTabContent">
                    <!-- Step 1 -->
                    <div class="tab-pane fade show active" id="step1" role="tabpanel" aria-labelledby="step1-tab">
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label mb-2">Tipe Kursus</label>
                                <div class="d-flex gap-2 flex-column flex-sm-row">
                                    <input type="hidden" name="type" id="type" value="{{ old('type', $course->type) }}">
                                    <div class="card course-type-card border-primary position-relative flex-fill" data-type="private" style="cursor:pointer; min-width:150px;">
                                        <div class="position-absolute top-0 end-0 m-2 z-index-2">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input course-type-checkbox" type="checkbox" id="type-private-checkbox" value="private" disabled {{ old('type', $course->type) == 'private' ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                        <div class="card-body text-center py-3">
                                            <i class="bi bi-person fs-2 text-primary"></i>
                                            <div class="fw-bold mt-2">Private</div>
                                        </div>
                                    </div>
                                    <div class="card course-type-card position-relative flex-fill" data-type="group" style="cursor:pointer; min-width:150px;">
                                        <div class="position-absolute top-0 end-0 m-2 z-index-2">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input course-type-checkbox" type="checkbox" id="type-group-checkbox" value="group" disabled {{ old('type', $course->type) == 'group' ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                        <div class="card-body text-center py-3">
                                            <i class="bi bi-people fs-2 text-primary"></i>
                                            <div class="fw-bold mt-2">Group</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label for="basic_skills" class="form-label">Catatan terkait murid</label>
                                <textarea name="basic_skills" id="basic_skills" class="form-control" rows="4">{{ old('basic_skills', $course->basic_skills) }}</textarea>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="students" class="form-label">Pilih Murid</label>
                            <div id="students-section">
                                <!-- Private: Dropdown -->
                                <div id="students-dropdown-section" style="{{ old('type', $course->type) == 'private' ? '' : 'display:none;' }}">
                                    <select class="form-select" name="students[]" id="student-private-dropdown">
                                        <option value="">-- Select Student --</option>
                                        @foreach ($students as $student)
                                            @php
                                                $dob = $student->birth_date ?? null;
                                                $age = $dob ? \Carbon\Carbon::parse($dob)->age : '-';
                                            @endphp
                                            <option value="{{ $student->id }}" {{ in_array($student->id, old('students', $course->students->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                {{ $student->user->name }} | {{ $student->user->email }} | ({{ $age }} tahun)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Group: Table with Checkbox & Search -->
                                <div id="students-table-section" style="{{ old('type', $course->type) == 'group' ? '' : 'display:none;' }}">
                                    <input type="text" id="student-search" class="form-control mb-2" placeholder="Search students by name or email">
                                    <div class="table-responsive" style="max-height: 300px; overflow-x: auto;">
                                        <table class="table table-bordered table-hover mb-0" id="students-table">
                                            <thead>
                                                <tr>
                                                    <th style="width:40px;">
                                                        <input type="checkbox" id="select-all-students">
                                                    </th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Tanggal Lahir</th>
                                                </tr>
                                            </thead>
                                            <tbody id="students-table-body">
                                                @foreach ($students as $student)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="student-checkbox"
                                                                name="students[]"
                                                                value="{{ $student->id }}"
                                                                {{ in_array($student->id, old('students', $course->students->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                        </td>
                                                        <td>{{ $student->user->name }}</td>
                                                        <td>{{ $student->user->email }}</td>
                                                        <td>
                                                            @php
                                                                $dob = $student->birth_date ?? null;
                                                                $age = $dob ? \Carbon\Carbon::parse($dob)->age : '-';
                                                            @endphp
                                                            {{ $dob ? \Carbon\Carbon::parse($dob)->format('d M Y') : '-' }} 
                                                            @if($age !== '-') 
                                                                <span class="text-muted">({{ $age }} tahun)</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="tab-pane fade" id="step2" role="tabpanel" aria-labelledby="step2-tab">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="venue_id" class="form-label fw-semibold">Venue</label>
                                <select name="venue_id" id="venue_id" class="form-select" required>
                                    <option value="">-- Select Venue --</option>
                                    @foreach ($venues as $venue)
                                        <option value="{{ $venue->id }}" {{ old('venue_id', $course->venue_id) == $venue->id ? 'selected' : '' }}>
                                            {{ $venue->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="price" class="form-label fw-semibold">Harga Kursus</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" min="0" name="price" id="price" class="form-control" value="{{ old('price', $course->price) }}" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="max_sessions" class="form-label fw-semibold">Total Sesi</label>
                                <div class="input-group">
                                    <input type="number" min="1" name="max_sessions" id="max_sessions" class="form-control" value="{{ old('max_sessions', $course->max_sessions) }}" required>
                                    <span class="input-group-text">Sesi</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="duration_days" class="form-label fw-semibold">Durasi</label>
                                <div class="input-group">
                                    <input type="number" min="1" name="duration_days" id="duration_days" class="form-control" value="{{ old('duration_days', $course->duration_days) }}" required>
                                    <span class="input-group-text">hari</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="start_date" class="form-label fw-semibold">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', $course->start_date ? $course->start_date->format('Y-m-d') : '') }}" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="valid_until" class="form-label fw-semibold">Tanggal Berakhir</label>
                                <input type="date" name="valid_until" id="valid_until" class="form-control" value="{{ old('valid_until', $course->valid_until ? $course->valid_until->format('Y-m-d') : '') }}" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="tab-pane fade" id="step3" role="tabpanel" aria-labelledby="step3-tab">
                        <div class="row">
                            <!-- Trainers List -->
                            <div class="col-12 mb-4">
                                <label class="form-label mb-2 fw-semibold fs-5">Pilih Pelatih</label>
                                <div class="position-relative">
                                    <button type="button" id="trainers-prev" class="btn btn-light btn-sm position-absolute top-50 start-0 translate-middle-y z-index-2 shadow d-none d-md-block" style="left: -30px; border-radius: 50%; width: 36px; height: 36px;">
                                        <i class="bi bi-chevron-left fs-3"></i>
                                    </button>
                                    <button type="button" id="trainers-next" class="btn btn-light btn-sm position-absolute top-50 end-0 translate-middle-y z-index-2 shadow d-none d-md-block" style="right: -30px; border-radius: 50%; width: 36px; height: 36px;">
                                        <i class="bi bi-chevron-right fs-3"></i>
                                    </button>
                                    <div id="trainers-carousel-viewport" class="overflow-auto w-100" style="min-height: 240px;">
                                        <div id="trainers-carousel" class="d-flex flex-row flex-nowrap" style="gap: 1rem; transition: transform 0.3s;">
                                            @foreach ($trainers->shuffle() as $trainer)
                                                <div class="trainer-card-wrapper flex-shrink-0" style="width: 100%; max-width: 260px;">
                                                    <div class="card card-flush h-100 border border-solid position-relative trainer-card box-shadow" style="cursor:pointer;">
                                                        <div class="position-absolute top-0 end-0 m-2 z-index-2">
                                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                                <input class="form-check-input trainer-checkbox" type="checkbox" name="trainers[]" value="{{ $trainer->id }}" id="trainer-{{ $trainer->id }}"
                                                                    {{ in_array($trainer->id, old('trainers', $course->trainers->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                            </div>
                                                        </div>
                                                        <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
                                                            <div class="symbol symbol-60px symbol-circle mb-3">
                                                                <img src="{{ $trainer->user->profile_photo_url ?? asset('assets/media/avatars/default-avatar.png') }}" alt="{{ $trainer->user->name }}">
                                                            </div>
                                                            <div class="fw-bold mb-2 text-center">
                                                                {{ $trainer->user->name }}
                                                            </div>
                                                            <div class="mb-1">
                                                                @php
                                                                    $dob = $trainer->user->date_of_birth ?? null;
                                                                    $age = $dob ? \Carbon\Carbon::parse($dob)->age : '-';
                                                                @endphp
                                                                <span class="badge badge-light-info">
                                                                    <i class="ki-duotone ki-calendar fs-6 me-1"></i> Age: {{ $age }}
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <span class="badge badge-light-primary">
                                                                    <i class="ki-duotone ki-briefcase fs-6 me-1"></i>
                                                                    Kursus Aktif: {{ $trainer->active_courses_count ?? 0 }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Materials List -->
                            <div class="col-12 mb-3">
                                <label class="form-label mb-2 fw-semibold fs-5">Pilih Materi</label>
                                <div id="materialsAccordion" class="accordion accordion-icon-toggle">
                                    @php
                                        $groupedMaterials = $materials->groupBy('level');
                                    @endphp
                                    @foreach ($groupedMaterials as $level => $levelMaterials)
                                        <div class="accordion-item mb-2">
                                            <h2 class="accordion-header" id="headingLevel{{ $level }}">
                                                <button class="accordion-button collapsed px-4 py-3 fs-6 fw-bold text-gray-800 bg-light-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLevel{{ $level }}" aria-expanded="false" aria-controls="collapseLevel{{ $level }}">
                                                    <span class="svg-icon svg-icon-2 me-2">
                                                        <i class="ki-duotone ki-element-11 fs-2 text-primary"></i>
                                                    </span>
                                                    <span>
                                                        <span class="text-muted">Level</span>
                                                        <span class="ms-1 text-primary">{{ $level }}</span>
                                                    </span>
                                                </button>
                                            </h2>
                                            <div id="collapseLevel{{ $level }}" class="accordion-collapse collapse" aria-labelledby="headingLevel{{ $level }}" data-bs-parent="#materialsAccordion">
                                                <div class="accordion-body p-0">
                                                    <div class="table-responsive" style="max-height: 220px; overflow-x: auto;">
                                                        <table class="table align-middle table-row-dashed gy-3 mb-0">
                                                            <thead class="bg-light-primary">
                                                                <tr class="fw-semibold text-gray-700">
                                                                    <th style="width:60px;"></th>
                                                                    <th>Materi</th>
                                                                    <th>Est. Sesi</th>
                                                                    <th>Min. Score</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($levelMaterials as $material)
                                                                    <tr>
                                                                        <td>
                                                                            <div class="d-flex justify-content-center">
                                                                                <div class="form-check form-check-sm form-check-custom form-check-solid ms-2">
                                                                                    <input class="form-check-input material-checkbox" type="checkbox" name="materials[]" value="{{ $material->id }}" data-estimated-sessions="{{ $material->estimated_sessions ?? 0 }}" data-min-score="{{ $material->minimum_score ?? 0 }}"
                                                                                        {{ in_array($material->id, old('materials', $course->materials->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <span class="fw-semibold">{{ $material->name }}</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="badge badge-light-primary fs-7">{{ $material->estimated_sessions ?? '-' }}</span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="badge badge-light-success fs-7">{{ $material->minimum_score ?? '-' }}</span>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-3">
                                    <div class="d-flex flex-wrap align-items-center gap-3">
                                        <div class="d-flex align-items-center">
                                            <span class="svg-icon svg-icon-2 text-primary me-1">
                                                <i class="ki-duotone ki-check-circle"></i>
                                            </span>
                                            <span class="fw-semibold">Terpilih: <span id="selected-materials-count" class="text-primary">0</span></span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="svg-icon svg-icon-2 text-warning me-1">
                                                <i class="ki-duotone ki-calendar"></i>
                                            </span>
                                            <span class="fw-semibold">Est. Sesi: <span id="selected-materials-sessions" class="text-warning">0</span></span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="svg-icon svg-icon-2 text-success me-1">
                                                <i class="ki-duotone ki-chart-line-up"></i>
                                            </span>
                                            <span class="fw-semibold">Avg. Min. Score: <span id="selected-materials-minscore" class="text-success">0</span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex flex-column flex-md-row justify-content-between gap-2">
                    <button type="button" class="btn btn-secondary w-100 w-md-auto" id="prevBtn" style="display: none;">Prev</button>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-primary w-100 w-md-auto" id="nextBtn">Next</button>
                        <button type="submit" class="btn btn-primary w-100 w-md-auto" id="submitBtn" style="display: none;">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</x-default-layout>

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .course-type-card {
            border-width: 1px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .course-type-card.selected, .course-type-card:hover {
            border-color: #0d6efd !important;
            box-shadow: 0 0 0 0.2rem rgba(13,110,253,.15);
        }
        @media (max-width: 576px) {
            .card { margin-bottom: 1rem !important; }
            .nav-tabs .nav-link { font-size: 0.95rem; padding: .5rem .5rem; }
            .form-label, .fw-bold, .fw-semibold { font-size: 0.97rem !important; }
            .table { font-size: 0.92rem; }
            .accordion-button { font-size: 1rem !important; }
            .btn { font-size: 0.97rem !important; }
            .course-type-card { min-width: 120px !important; }
            .card-body { padding: 1rem !important; }
        }
        .overflow-auto { overflow-x: auto !important; }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/js/courses-edit.js') }}"></script>
@endpush