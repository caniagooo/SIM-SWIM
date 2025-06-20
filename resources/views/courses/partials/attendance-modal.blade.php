<div class="modal fade" id="attendanceModal{{ $session->id }}" tabindex="-1" aria-labelledby="attendanceModalLabel{{ $session->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light-primary">
                <h5 class="modal-title" id="attendanceModalLabel{{ $session->id }}">
                    <i class="bi bi-clipboard-check text-primary me-2"></i>
                    Attendance for Session:
                    <span class="fw-bold text-primary">{{ \Carbon\Carbon::parse($session->session_date)->translatedFormat('l, d F Y') }}</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="attendanceForm{{ $session->id }}">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <input type="hidden" name="course_session_id" value="{{ $session->id }}">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed gy-3">
                            <thead class="bg-light">
                                <tr class="text-center text-gray-600 fw-bold">
                                    <th class="min-w-50px">#</th>
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