<x-default-layout>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <!-- Header -->
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="card-title text-white">Course Details</h3>
                <div class="card-toolbar">
                    <a href="{{ route('courses.index') }}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Back to course list">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-light-primary btn-sm ms-2" data-bs-toggle="tooltip" title="Edit this course">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>

            <!-- Body -->
            <div class="card-body">
                <!-- Tabs -->
                <div class="row">
                    <ul class="nav nav-tabs mb-3" id="courseTabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">Course Info</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="sessions-tab" data-bs-toggle="tab" data-bs-target="#sessions" type="button" role="tab" aria-controls="sessions" aria-selected="false">Sessions</button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="courseTabsContent">
                        <!-- Course Info Tab -->
                        <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6 mb-4">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <h6 class="text-primary mb-3"><i class="bi bi-info-circle"></i> Basic Information</h6>
                                            <table class="table table-borderless table-sm mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="fw-bold text-gray-700">Name</td>
                                                        <td>{{ $course->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold text-gray-700">Type</td>
                                                        <td><span class="badge bg-warning">{{ ucfirst($course->type) }}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold text-gray-700">Venue</td>
                                                        <td>{{ $course->venue->name ?? 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold text-gray-700">Price</td>
                                                        <td>Rp. {{ number_format($course->price) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6 mb-4">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <h6 class="text-primary mb-2"><i class="bi bi-calendar-range"></i> Course Duration</h6>
                                            <table class="table table-borderless table-sm mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="fw-bold text-gray-700">Start</td>
                                                        <td>{{ $course->start_date ? $course->start_date->translatedFormat('l, d F Y') : 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold text-gray-700">End</td>
                                                        <td>{{ $course->valid_until ? $course->valid_until->translatedFormat('l, d F Y') : 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        @php
                                                            $max = $course->max_sessions ?? 0;
                                                            $scheduled = $course->sessions->count();
                                                            $completed = $course->sessions->where('status', 'completed')->count();
                                                            $unscheduled = max(0, $max - $scheduled);
                                                        @endphp
                                                        <td class="fw-bold text-gray-700">Sesi</td>
                                                        <td>
                                                            <span class="text-success"> {{ $completed }} </span> / 
                                                            <span class="text-info"> {{ $course->max_sessions ?? 'N/A' }} </span> Sesi Pertemuan
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-bold text-gray-700">Trainer</td>
                                                        <td>
                                                            @if ($course->trainers->count() > 0)
                                                                <ul class="list-group list-group-flush mb-3">
                                                                    @foreach ($course->trainers as $trainer)
                                                                        <li class="list-group-item">{{ $trainer->user->name }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            @else
                                                                <span class="text-muted">No trainer assigned</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Students -->
                            <div class="col-md-12 mb-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <h6 class="text-primary mb-2"><i class="bi bi-people"></i> Students</h6>
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>#</th>
                                                        <th>Foto</th>
                                                        <th>Nama</th>
                                                        <th>Kehadiran</th>
                                                        <th>Nilai Rata-Rata</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($course->students as $student)
                                                        @php
                                                            $attendanceCount = $student->sessions->where('course_id', $course->id)->count();
                                                            $maxSessions = $course->max_sessions ?? 0;
                                                            // Hitung rata-rata nilai dari seluruh materi kursus untuk siswa ini
                                                            $materialIds = $course->materials->pluck('id');
                                                            $totalScore = \DB::table('student_grades')
                                                                ->where('student_id', $student->id)
                                                                ->whereIn('material_id', $materialIds)
                                                                ->avg('score');
                                                            $averageScore = $totalScore ? number_format($totalScore, 1) : '-';
                                                        @endphp
                                                        <tr>
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td class="text-center">
                                                                <img src="{{ $student->user->profile_photo_path ?? asset('assets/media/avatars/default-avatar.png') }}" alt="Avatar" class="rounded-circle" width="50" height="50">
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('students.show', $student->id) }}" class="text-primary fw-bold">
                                                                    {{ $student->user->name }}
                                                                </a>
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $attendanceCount }} / {{ $maxSessions }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $averageScore }}
                                                            </td>
                                                            <td class="text-center">
                                                                <button class="btn btn-light-primary btn-sm" data-bs-toggle="modal" data-bs-target="#studentDetailModal{{ $student->id }}">
                                                                    <i class="fas fa-edit"></i> Penilaian
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="6" class="text-center text-muted">No students enrolled in this course.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sessions Tab -->
                        <div class="tab-pane fade" id="sessions" role="tabpanel" aria-labelledby="sessions-tab">
                            <div class="col-md-12 mb-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <h6 class="text-primary mb-3"><i class="bi bi-calendar-check"></i> Sessions</h6>

                                        <!-- Button Tambah Jadwal -->
                                        <div class="d-flex justify-content-between mb-3">
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addScheduleModal"
                                                {{ $course->sessions->count() >= $course->max_sessions ? 'disabled' : '' }}>
                                                + Tambah Jadwal
                                            </button>
                                            @if ($course->sessions->count() >= $course->max_sessions)
                                                <small class="text-danger">Max sessions reached ({{ $course->max_sessions }})</small>
                                            @endif
                                        </div>

                                        <!-- Tabel Jadwal Sesi -->
                                        @if ($course->sessions && $course->sessions->count() > 0)
                                            <div class="table-responsive">
                                                <table id="sessionsTable" class="table align-middle table-row-dashed fs-6 gy-4">
                                                    <thead>
                                                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                            <th class="min-w-50px">#</th>
                                                            <th class="min-w-150px">Date</th>
                                                            <th class="min-w-100px">Start Time</th>
                                                            <th class="min-w-100px">End Time</th>
                                                            <th class="min-w-100px">Status</th>
                                                            <th class="min-w-150px text-end">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="fw-semibold text-gray-700">
                                                        @foreach ($course->sessions->whereIn('status', ['scheduled', 'completed']) as $session)
                                                            <tr id="sessionRow{{ $session->id }}">
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>
                                                                    <span class="badge badge-light-primary fs-7">
                                                                        {{ \Carbon\Carbon::parse($session->session_date)->translatedFormat('l, d F Y') }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <span class="badge badge-light-info fs-7">
                                                                        {{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <span class="badge badge-light-info fs-7">
                                                                        {{ \Carbon\Carbon::parse($session->end_time)->format('H:i') }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <span id="sessionsStatus{{ $session->id }}" class="badge badge-{{ $session->status == 'completed' ? 'success' : 'info' }} fs-7">
                                                                        {{ ucfirst($session->status) }}
                                                                    </span>
                                                                </td>
                                                                <td class="text-end">
                                                                    <div class="d-flex justify-content-end gap-2">
                                                                        <!-- Button Absen -->
                                                                        <button class="btn btn-icon btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#attendanceModal{{ $session->id }}" title="Absen">
                                                                            <i class="fas fa-clipboard-check"></i>
                                                                        </button>
                                                                        <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-light-warning" data-bs-toggle="modal" data-bs-target="#editScheduleModal{{ $session->id }}" title="Edit">
                                                                            <i class="fas fa-edit"></i>
                                                                        </a>
                                                                        <form action="{{ route('sessions.destroy', [$course->id, $session->id]) }}" method="POST" style="display:inline;">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-icon btn-sm btn-light-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                                                                <i class="fas fa-trash-alt"></i>
                                                                            </form>
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                            
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="alert alert-info d-flex align-items-center p-4">
                                                <i class="bi bi-info-circle fs-2x me-3"></i>
                                                <div>
                                                    <span class="fw-semibold">No sessions scheduled.</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Alert Container -->
                    <div id="alertContainer" class="alert d-none alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <i id="alertIcon" class="bi me-2"></i>
                            <span id="alertMessage"></span>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <!-- end Alert Container -->
            </div>
        </div>
    </div>

<!-- Attendance Modal -->    
@foreach ($course->sessions as $session)
    <div class="modal fade" id="attendanceModal{{ $session->id }}" tabindex="-1" aria-labelledby="attendanceModalLabel{{ $session->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light-primary">
                    <h5 class="modal-title" id="attendanceModalLabel{{ $course->id }}">
                        <i class="bi bi-clipboard-check text-primary me-2"></i>
                        Attendance for Session: 
                        <span class="fw-bold text-primary">{{ \Carbon\Carbon::parse($session->session_date)->translatedFormat('l, d F Y') }}</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="attendanceForm{{ $session->id }}" method="POST">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <input type="hidden" name="course_session_id" value="{{ $session->id }}">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed gy-3">
                                <thead class="bg-light">
                                    <tr class="text-center text-gray-600 fw-bold">
                                        <th class="min-w-50px">#</th></tbody>
                                        <th class="min-w-200px">Nama Murid</th>
                                        <th class="min-w-300px">Status Kehadiran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($course->students as $student)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="symbol symbol-40px me-3">
                                                        <img src="{{ $student->user->profile_photo_path ?? asset('assets/media/avatars/default-avatar.png') }}" alt="Avatar" class="rounded-circle" width="40" height="40">
                                                    </div>
                                                    <span class="fw-semibold text-gray-800">{{ $student->user->name }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group w-100" role="group" aria-label="Status Kehadiran">
                                                    <input type="radio" class="btn-check" name="attendance[{{ $student->id }}][status]" id="hadir-{{ $session->id }}-{{ $student->id }}" value="hadir" autocomplete="off">
                                                    <label class="btn btn-sm btn-light-success fw-bold px-4" for="hadir-{{ $session->id }}-{{ $student->id }}">
                                                        <i class="bi bi-check-circle me-1"></i> Hadir
                                                    </label>

                                                    <input type="radio" class="btn-check" name="attendance[{{ $student->id }}][status]" id="tidak-hadir-{{ $session->id }}-{{ $student->id }}" value="tidak hadir" autocomplete="off">
                                                    <label class="btn btn-sm btn-light-danger fw-bold px-4" for="tidak-hadir-{{ $session->id }}-{{ $student->id }}">
                                                        <i class="bi bi-x-circle me-1"></i> Tidak Hadir
                                                    </label>

                                                    <input type="radio" class="btn-check" name="attendance[{{ $student->id }}][status]" id="terlambat-{{ $session->id }}-{{ $student->id }}" value="terlambat" autocomplete="off">
                                                    <label class="btn btn-sm btn-light-warning fw-bold px-4" for="terlambat-{{ $session->id }}-{{ $student->id }}">
                                                        <i class="bi bi-clock-history me-1"></i> Terlambat
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-4">
                            <i class="bi bi-save me-2"></i> Simpan Kehadiran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
    <!-- Modal Tambah Jadwal -->
    <div class="modal fade" id="addScheduleModal" tabindex="-1" aria-labelledby="addScheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addScheduleModalLabel">Tambah Jadwal Sesi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addScheduleForm">
                        @csrf
                        <div class="mb-3">
                            <label for="session_date" class="form-label">Tanggal Sesi</label>
                            <input type="date" class="form-control" id="session_date" name="session_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="start_time" class="form-label">Waktu Mulai</label>
                            <input type="time" class="form-control" id="start_time" name="start_time" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_time" class="form-label">Waktu Selesai</label>
                            <input type="time" class="form-control" id="end_time" name="end_time" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


<!-- Edit Schedule Modal -->
@foreach ($course->sessions as $session)
    <div class="modal fade" id="editScheduleModal{{ $session->id }}" tabindex="-1" aria-labelledby="editScheduleModalLabel{{ $session->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editScheduleModalLabel{{ $session->id }}">Edit Jadwal Sesi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editScheduleForm{{ $session->id }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="session_date_{{ $session->id }}" class="form-label">Tanggal Sesi</label>
                            <input type="date" class="form-control" id="session_date_{{ $session->id }}" name="session_date"
                                value="{{ $session->session_date ? $session->session_date->format('Y-m-d') : '' }}"
                                placeholder="{{ $session->session_date ? $session->session_date->format('d M Y') : '-' }}" required>
                            <small class="text-muted">Tanggal sebelumnya: {{ $session->session_date ? \Carbon\Carbon::parse($session->session_date)->translatedFormat('l, d F Y') : '-' }}</small>
                        </div>
                        <div class="mb-3">
                            <label for="start_time_{{ $session->id }}" class="form-label">Waktu Mulai</label>
                            <input type="time" class="form-control" id="start_time_{{ $session->id }}" name="start_time"
                                value="{{ $session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('H:i') : '' }}"
                                placeholder="{{ $session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('H:i') : '-' }}" required>
                            <small class="text-muted">Waktu sebelumnya: {{ $session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('H:i') : '-' }}</small>
                        </div>
                        <div class="mb-3">
                            <label for="end_time_{{ $session->id }}" class="form-label">Waktu Selesai</label>
                            <input type="time" class="form-control" id="end_time_{{ $session->id }}" name="end_time"
                                value="{{ $session->end_time ? \Carbon\Carbon::parse($session->end_time)->format('H:i') : '' }}"
                                placeholder="{{ $session->end_time ? \Carbon\Carbon::parse($session->end_time)->format('H:i') : '-' }}" required>
                            <small class="text-muted">Waktu sebelumnya: {{ $session->end_time ? \Carbon\Carbon::parse($session->end_time)->format('H:i') : '-' }}</small>
                        </div>
                        <div class="mb-3">
                            <label for="status_{{ $session->id }}" class="form-label">Status</label>
                            <select class="form-select" id="status_{{ $session->id }}" name="status" required>
                                <option value="scheduled" {{ $session->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="cancelled" {{ $session->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <small class="text-muted">Status sebelumnya: {{ ucfirst($session->status) }}</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach



@foreach ($course->students as $student)
    <div class="modal fade" id="studentDetailModal{{ $student->id }}" tabindex="-1" aria-labelledby="studentDetailModalLabel{{ $student->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="studentDetailModalLabel{{ $student->id }}">
                        Penilaian untuk: <strong>{{ $student->user->name }}</strong>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="gradingForm{{ $student->id }}">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}"> <!-- Tambahkan course_id -->
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="bg-light">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Materi</th>
                                        <th>Penilaian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($course->materials as $material)
                                        @php
                                            $grade = $material->grades->where('student_id', $student->id)->first();
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $material->name }}</td>
                                            <td class="text-center">
                                                <input type="hidden" name="grades[{{ $material->id }}][material_id]" value="{{ $material->id }}">
                                                <div class="btn-group" role="group" aria-label="Penilaian">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <input type="radio" class="btn-check" name="grades[{{ $material->id }}][score]" id="grade-{{ $student->id }}-{{ $material->id }}-{{ $i }}" value="{{ $i }}"
                                                            {{ isset($grade->score) && $grade->score == $i ? 'checked' : '' }}>
                                                        <label class="btn btn-sm btn-outline-primary" for="grade-{{ $student->id }}-{{ $material->id }}-{{ $i }}">{{ $i }}</label>
                                                    @endfor
                                                </div>
                                                @if ($grade)
                                                    <span class="badge bg-success">Nilai sudah berhasil disimpan</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-3">Simpan Penilaian</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach


<!-- Javascript -->

<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables Initialization -->
<script>
    $(document).ready(function () {
        $('#sessionsTable').DataTable();
        $('#materialsTable').DataTable();
        $('#studentsTable').DataTable();
    });
</script>



<!-- Attendance Form Submission -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $(document).ready(function () {
            @foreach ($course->sessions as $session)
                $('#attendanceForm{{ $session->id }}').on('submit', function (e) {
                    e.preventDefault();

                    // Log data yang akan dikirimkan
                    console.log($(this).serialize());

                    $.ajax({
                        url: "{{ route('sessions.attendance.save', ['course' => $course->id, 'session' => $session->id]) }}",
                        method: "POST",
                        data: $(this).serialize(),
                        success: function (response) {
                            // Log respons sukses dari server
                            console.log('Response:', response);

                            alert(response.message);
                            $('#attendanceModal{{ $session->id }}').modal('hide');
                        },
                        error: function (xhr) {
                            // Log error dari server
                            console.error('Error Response:', xhr.responseText);

                            alert('Terjadi kesalahan saat menyimpan kehadiran.');
                        }
                    });
                });
            @endforeach
        });
    });
</script>

<!-- Add Schedule Form Submission -->
<script>
    $(document).ready(function () {
        $('#addScheduleForm').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('sessions.store', ['course' => $course->id]) }}",
                method: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    showAlert('success', 'Jadwal sesi berhasil ditambahkan.');
                    $('#addScheduleModal').modal('hide');

                    $('#sessionsTable tbody').append(`
                        <tr>
                            <td>${response.data.id}</td>
                            <td><span class="badge badge-light-primary fs-7">${response.data.session_date}</td>
                            <td><span class="badge badge-light-info fs-7">${response.data.start_time}</td>
                            <td><span class="badge badge-light-info fs-7">${response.data.end_time}</td>
                            <td><span class="badge badge-info fs-7">Scheduled</span></td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <button class="btn btn-icon btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#attendanceModal${response.data.id}" title="Absen">
                                        <i class="fas fa-clipboard-check"></i>
                                    </button>
                                    <a href="#" class="btn btn-icon btn-sm btn-light-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-icon btn-sm btn-light-danger" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `);
                },
                error: function () {
                    showAlert('danger', 'Terjadi kesalahan saat menambahkan jadwal. Silakan coba lagi.');
                }
            });
        });
    });
</script>

<!-- Edit Schedule Form -->
<script>
    $(document).ready(function () {
        @foreach ($course->sessions as $session)
            $('#editScheduleForm{{ $session->id }}').on('submit', function (e) {
                e.preventDefault(); // Prevent default form submission

                // Get the form data
                var formData = $(this).serialize();

                // Menampilkan data existing
                console.log('Editing session:', {{ $session->id }}, formData);

                


                // Send AJAX request
                $.ajax({
                    url: "{{ route('sessions.update', ['course' => $course->id, 'session' => $session->id]) }}",
                    method: "PUT",
                    data: formData,
                    success: function (response) {
                        console.log(response); // Log respons JSON ke konsol
                        showAlert('success', 'Jadwal sesi berhasil diperbarui.');

                        // Close the modal
                        $('#editScheduleModal{{ $session->id }}').modal('hide');

                        // Update the row in the table dynamically
                        const row = $(`#sessionRow${response.data.id}`);
                        // Format tanggal ke "Senin, 18 Januari 2025"
                        const date = new Date(response.data.session_date);
                        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                        const months = [
                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                        ];
                        const formattedDate = `${days[date.getDay()]}, ${date.getDate().toString().padStart(2, '0')} ${months[date.getMonth()]} ${date.getFullYear()}`;
                        row.find('td:nth-child(2) span').text(formattedDate);
                        row.find('td:nth-child(3) span').text(response.data.start_time);
                        row.find('td:nth-child(4) span').text(response.data.end_time);
                        row.find('td:nth-child(5) span').text(response.data.status);
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText); // Log error ke konsol
                        showAlert('danger', 'Terjadi kesalahan saat memperbarui jadwal. Silakan coba lagi.');
                    }
                });
            });
        @endforeach
    });
</script>

<!-- Alert Handling Function -->
<script>
    function showAlert(type, message) {
        const alertContainer = $('#alertContainer');
        const alertIcon = $('#alertIcon');
        const alertMessage = $('#alertMessage');

        alertContainer.removeClass('d-none alert-success alert-danger alert-info alert-warning');
        alertContainer.addClass(`alert-${type}`);
        alertMessage.text(message);

        alertIcon.removeClass('bi-check-circle bi-x-circle bi-info-circle bi-exclamation-triangle');
        if (type === 'success') {
            alertIcon.addClass('bi-check-circle text-success');
        } else if (type === 'danger') {
            alertIcon.addClass('bi-x-circle text-danger');
        } else if (type === 'info') {
            alertIcon.addClass('bi-info-circle text-info');
        } else if (type === 'warning') {
            alertIcon.addClass('bi-exclamation-triangle text-warning');
        }

        alertContainer.fadeIn();
        setTimeout(() => alertContainer.fadeOut(), 3000);
    }
</script>

<script>
    $(document).ready(function () {
        @foreach ($course->students as $student)
            $('#gradingForm{{ $student->id }}').on('submit', function (e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('grades.store', ['course' => $course->id, 'student' => $student->id]) }}",
                    method: "POST",
                    data: formData,
                    success: function (response) {
                        console.log('Response:', response);
                        showAlert('success', 'Penilaian berhasil disimpan.');
                        $('#studentDetailModal{{ $student->id }}').modal('hide');
                    },
                    error: function (xhr) {
                        console.error('Error:', xhr.responseText);
                        showAlert('danger', 'Terjadi kesalahan saat menyimpan penilaian.');
                    }
                });
            });
        @endforeach
    });
</script>

</x-default-layout>