<!-- Modal Jadwal Sesi -->
<div class="modal fade" id="sessionsModal-{{ $course->id }}" tabindex="-1" aria-labelledby="sessionsModalLabel-{{ $course->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-3 shadow-sm">
            <div class="modal-header bg-light-info border-0 pb-2">
                <h5 class="modal-title fw-bold" id="sessionsModalLabel-{{ $course->id }}">
                    <div><i class="bi bi-calendar-event me-2 text-info"></i> Jadwal Sesi</div>
                    <div>
                        <span class="text-dark fs-8">{{ $course->name }}</span>
                        <span class="text-dark">
                            <a href="{{ route('courses.show', $course->id) }}" class="bi-eye ms-1 text-decoration-none text-dark" title="Lihat Detail Kursus">
                                <span class="badge badge-light-primary"> lihat detail</span>
                            </a>
                        </span>
                    </div>
                </h5>
                <button type="button" class="btn btn-icon btn-sm btn-light" data-bs-dismiss="modal" aria-label="Tutup">
                    <i class="bi bi-x fs-2"></i>
                </button>
            </div>
            <div class="modal-body py-3 px-2">
                <!-- Info Ringkas Kursus -->
                <div class="d-flex flex-wrap px-5 gap-2 mb-3 justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-people text-primary fs-5"></i>
                        @if($course->students->count())
                            @foreach($course->students as $student)
                                <img src="{{ $student->user->profile_photo_path ?? asset('assets/media/avatars/default-avatar.png') }}"
                                     alt="{{ $student->user->name }}"
                                     class="rounded-circle border border-2 border-white"
                                     style="width: 32px; height: 32px; object-fit: cover; background: #f1f1f1"
                                     data-bs-toggle="tooltip"
                                     data-bs-placement="top"
                                     title="{{ $student->user->name }}">
                            @endforeach
                        @else
                            <span class="text-muted small">-</span>
                        @endif
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-clock-history text-success fs-5"></i>
                        <span class="small">
                            {{ $course->start_date ? \Carbon\Carbon::parse($course->start_date)->translatedFormat('d F Y') : '-' }}
                            -
                            {{ $course->valid_until ? \Carbon\Carbon::parse($course->valid_until)->translatedFormat('d F Y') : '-' }}
                        </span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-geo-alt-fill text-danger fs-5"></i>
                        <span class="small">{{ $course->venue->name ?? '-' }}</span>
                    </div>
                </div>
                <!-- Tabel Sesi -->
                @php
                    // Query langsung ke database untuk mengambil sesi kursus
                    $sessions = \DB::table('course_sessions')
                        ->where('course_id', $course->id)
                        ->orderBy('session_date')
                        ->get();
                @endphp
                @if($sessions->count())
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center" style="width:40px;">#</th>
                                    <th>Tanggal</th>
                                    <th>start time</th>
                                    <th>end time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sessions as $idx => $session)
                                    <tr>
                                        <td class="text-center text-gray-600 fw-bold">{{ $idx+1 }}</td>
                                        <td class="text-nowrap">
                                            <i class="bi bi-clock me-1 text-primary"></i>
                                            {{ \Carbon\Carbon::parse($session->session_date)->format('d M Y H:i') }}
                                        </td>
                                        <td class="text-nowrap">
                                            <i class="bi bi-clock me-1 text-success"></i>
                                            {{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }}
                                        </td>
                                        <td class="text-nowrap">
                                            <i class="bi bi-clock me-1 text-danger"></i>
                                            {{ \Carbon\Carbon::parse($session->end_time)->format('H:i') }}
                                        </td>
                                        <td>
                                            <span class="badge 
                                                @if($session->status === 'completed') badge-light-success
                                                @elseif($session->status === 'scheduled') badge-light-info
                                                @else badge-light-secondary
                                                @endif
                                                px-3 py-2 fw-semibold text-capitalize">
                                                {{ __($session->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info d-flex align-items-center justify-content-center mb-0 py-6">
                        <i class="bi bi-info-circle me-2 fs-2"></i>
                        <span class="fs-6">Belum ada sesi dijadwalkan untuk kursus ini.</span>
                    </div>
                @endif
            </div>
            <div class="modal-footer bg-light border-0 pt-2">
                <button type="button" class="btn btn-light w-100 py-2" data-bs-dismiss="modal">
                    <i class="bi bi-arrow-left me-2"></i>Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Aktifkan tooltip untuk elemen di dalam modal
    $(document).ready(function() {
        $('#sessionsModal-{{ $course->id }}').on('shown.bs.modal', function () {
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    });
</script>