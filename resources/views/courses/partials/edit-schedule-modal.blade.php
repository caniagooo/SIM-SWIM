<div class="modal fade" id="editScheduleModal{{ $session->id }}" tabindex="-1" aria-labelledby="editScheduleModalLabel{{ $session->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editScheduleForm{{ $session->id }}"
              action="{{ route('sessions.update', ['course' => $course->id, 'session' => $session->id]) }}"
              method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            <input type="hidden" name="course_session_id" value="{{ $session->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editScheduleModalLabel{{ $session->id }}">Update Jadwal Sesi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <!-- Informasi Kursus -->
                    <div class="mb-3">
                        <div class="row">
                            <!-- Kolom Kiri: Nama Kursus & Info Sesi -->
                            <div class="col-6">
                                <div class="d-flex align-items-center mb-1">
                                    <span class="symbol symbol-35px symbol-circle bg-light-primary me-2">
                                        <i class="bi bi-book fs-3 text-primary"></i>
                                    </span>
                                    <div>
                                        <div class="fw-bold fs-6 text-gray-800">{{ $course->name }}</div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <span class="badge badge-light-primary">
                                        Sesi ke-{{ $loop->iteration ?? ($session->number ?? '-') }} dari {{ $course->max_sessions ?? '-' }} sesi
                                    </span>
                                </div>
                            </div>
                            <!-- Kolom Kanan: Venue & Avatar Murid -->
                            <div class="col-6">
                                <div class="mb-2">
                                    <div class="text-muted fs-8">
                                        <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                        {{ $course->venue->name ?? '-' }}
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-wrap gap-1">
                                    @foreach($course->students as $student)
                                        <div class="symbol symbol-30px symbol-circle" data-bs-toggle="tooltip" title="{{ $student->user->name }}">
                                            <img src="{{ $student->user->profile_photo_path ?? asset('assets/media/avatars/default-avatar.png') }}"
                                                 alt="{{ $student->user->name }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="separator my-3"></div>
                    <!-- Form Edit Jadwal Compact -->
                    <div class="row g-2">
                        <div class="col-6">
                            <label for="session_date_{{ $session->id }}" class="form-label mb-1">Tanggal</label>
                            <input type="date" class="form-control form-control-sm" id="session_date_{{ $session->id }}" name="session_date"
                                   value="{{ old('session_date', $session->session_date) }}" required>
                            <small class="text-muted fs-8">
                                {{ \Carbon\Carbon::parse($session->session_date)->translatedFormat('l, d F Y') }}
                            </small>
                        </div>
                        <div class="col-3">
                            <label for="start_time_{{ $session->id }}" class="form-label mb-1">Mulai</label>
                            <input type="time" class="form-control form-control-sm" id="start_time_{{ $session->id }}" name="start_time"
                                   value="{{ old('start_time', $session->start_time) }}" required>
                            <small class="text-muted fs-8">
                                {{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }}
                            </small>
                        </div>
                        <div class="col-3">
                            <label for="end_time_{{ $session->id }}" class="form-label mb-1">Selesai</label>
                            <input type="time" class="form-control form-control-sm" id="end_time_{{ $session->id }}" name="end_time"
                                   value="{{ old('end_time', $session->end_time) }}" required>
                            <small class="text-muted fs-8">
                                {{ \Carbon\Carbon::parse($session->end_time)->format('H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
                </div>
                
            </div>
            <!-- Alert Container -->
                <div id="alertContainer" class="alert d-none alert-dismissible fade show mt-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i id="alertIcon" class="bi me-2"></i>
                        <span id="alertMessage"></span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <!-- end Alert Container -->
        </form>
    </div>
</div>