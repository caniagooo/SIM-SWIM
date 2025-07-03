<div class="table-responsive">
    <table id="sessionsTable" class="table table-hover align-middle mb-0">
        <thead>
            <tr>
                <th style="width: 3%;">#</th>
                <th style="width: 22%;">Tanggal</th>
                <th style="width: 13%;">Jam Mulai</th>
                <th style="width: 13%;">Jam Selesai</th>
                <th style="width: 14%;">Status</th>
                <th style="width: 35%;" class="text-end">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sessions as $i => $session)
                <tr id="sessionRow{{ $session->id }}">
                    <td>{{ $i+1 }}</td>
                    <td>
                        <i class="bi bi-clock me-1 text-primary"></i>
                        {{ \Carbon\Carbon::parse($session->date ?? $session->session_date)->format('d M Y') }}
                    </td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }}
                    </td>
                    <td class="text-center">
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
                    <td class="text-end">
                        <div class="btn-group btn-group-sm" role="group" aria-label="Aksi">
                            <button type="button"
                                class="btn btn-icon btn-light-success btnAttendance"
                                data-session-id="{{ $session->id }}"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Presensi"
                                data-bs-toggle="modal"
                                data-bs-target="#attendanceModal-{{ $session->id }}">
                                <i class="bi bi-person-check"></i>
                            </button>
                            @if($session->status === 'scheduled')
                                <button type="button"
                                    class="btn btn-icon btn-light-warning btnEditSession"
                                    data-session-id="{{ $session->id }}"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Edit Jadwal"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editScheduleModal-{{ $session->id }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            @endif
                            <button type="button"
                                class="btn btn-icon btn-light-danger btnDeleteSession"
                                data-session-id="{{ $session->id }}"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Hapus Sesi">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<button type="button"
        class="btn btn-primary mt-3"
        data-bs-toggle="modal"
        data-bs-target="#addScheduleModal-{{ $course->id }}">
    <i class="bi bi-plus-circle"></i> Tambah Sesi
</button>

<script>
    // Aktifkan tooltip Bootstrap 5 pada semua tombol aksi
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>