<x-default-layout>
    <div class="container mt-5">
        <!-- Row Pertama: Informasi Sesi dan Kursus -->
        <div class="row mb-4">
            <!-- Kolom Gabungan: Session Info dan Course Info -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Session Info</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Session:</strong> {{ $session->id }} of {{ $session->course->max_sessions }}</p>
                        <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($session->session_date)->translatedFormat('l, j F Y') }}</p>
                        <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($session->end_time)->format('H:i') }}</p>
                        <p><strong>Venue:</strong> {{ $session->course->venue->name ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Course Info</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Course Name:</strong> {{ $session->course->name }}</p>
                        <p><strong>Course Type:</strong> <span class="badge bg-info">{{ ucfirst($session->course->type) }}</span></p>
                        <p><strong>Trainer:</strong>
                            @if($session->course->trainers && $session->course->trainers->count())
                                {{ $session->course->trainers->map(function($trainer) { return $trainer->user->name; })->join(', ') }}
                            @else
                                N/A
                            @endif
                        </p>
                        <p><strong>Participant:</strong> {{ $session->course->students->count() }} Peserta</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row Kedua: Daftar Murid dan Absensi -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0 text-muted">Student Attendance</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('attendance.store', $session->id) }}">
                    @csrf
                    <div class="row">
                        @foreach ($session->students as $student)
                            <div class="col-md-6 col-sm-12 mb-3">
                                <div class="card shadow-sm">
                                    <div class="card-body d-flex flex-column flex-sm-row align-items-center">
                                        <img src="{{ $student->user->profile_picture ?? 'default-avatar.png' }}" alt="Profile Picture" class="rounded-circle me-3 mb-3 mb-sm-0" width="50" height="50">
                                        <div class="flex-grow-1 text-center text-sm-start">
                                            <p class="mb-0"><strong>{{ $student->user->name }}</strong></p>
                                            <p class="mb-0 text-muted">Usia: 
                                                @if($student->birth_date)
                                                    {{ \Carbon\Carbon::parse($student->birth_date)->age }} tahun
                                                @else
                                                    N/A
                                                @endif
                                            </p>
                                            <div class="btn-group mt-2" role="group" aria-label="Attendance Status">
                                                <input type="radio" class="btn-check" name="attendance[{{ $student->id }}][status]" id="hadir-{{ $student->id }}" value="hadir" autocomplete="off">
                                                <label class="btn btn-outline-primary btn-sm" for="hadir-{{ $student->id }}">Hadir</label>

                                                <input type="radio" class="btn-check" name="attendance[{{ $student->id }}][status]" id="tidak-hadir-{{ $student->id }}" value="tidak hadir" autocomplete="off">
                                                <label class="btn btn-outline-danger btn-sm" for="tidak-hadir-{{ $student->id }}">Tidak Hadir</label>

                                                <input type="radio" class="btn-check" name="attendance[{{ $student->id }}][status]" id="terlambat-{{ $student->id }}" value="terlambat" autocomplete="off">
                                                <label class="btn btn-outline-warning btn-sm" for="terlambat-{{ $student->id }}">Terlambat</label>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#scoreModal{{ $student->id }}">Score</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Box untuk Penilaian -->
                            <div class="modal fade" id="scoreModal{{ $student->id }}" tabindex="-1" aria-labelledby="scoreModalLabel{{ $student->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="scoreModalLabel{{ $student->id }}">Penilaian Materi | {{ $student->user->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @foreach ($session->course->materials as $material)
                                                <div class="mb-3">
                                                    <p class="fw-bold">{{ $material->name }}</p>
                                                    <div class="d-flex align-items-center">
                                                        <!-- Skor -->
                                                        <span class="text-muted">Nilai: </span>
                                                        <div class="btn-group me-3" role="group" aria-label="Score Options">
                                                            <input type="radio" class="btn-check" name="scores[{{ $student->id }}][{{ $material->id }}][score]" id="score-1-{{ $student->id }}-{{ $material->id }}" value="1" autocomplete="off">
                                                            <label class="btn btn-outline-danger btn-sm" for="score-1-{{ $student->id }}-{{ $material->id }}">1</label>

                                                            <input type="radio" class="btn-check" name="scores[{{ $student->id }}][{{ $material->id }}][score]" id="score-2-{{ $student->id }}-{{ $material->id }}" value="2" autocomplete="off">
                                                            <label class="btn btn-outline-warning btn-sm" for="score-2-{{ $student->id }}-{{ $material->id }}">2</label>

                                                            <input type="radio" class="btn-check" name="scores[{{ $student->id }}][{{ $material->id }}][score]" id="score-3-{{ $student->id }}-{{ $material->id }}" value="3" autocomplete="off">
                                                            <label class="btn btn-outline-success btn-sm" for="score-3-{{ $student->id }}-{{ $material->id }}">3</label>
                                                        </div>
                                                        <!-- Catatan -->
                                                        <textarea name="scores[{{ $student->id }}][{{ $material->id }}][remarks]" class="form-control" rows="2" placeholder="Remarks (optional)"></textarea>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save Scores</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary">Save Attendance</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-default-layout>