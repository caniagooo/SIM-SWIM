
<x-default-layout>
    @section('title')
        Dashboard
    @endsection

    <div class="container-xxl mt-8">
        <!-- Summary Row -->
        <div class="row g-4 mb-7">
            <div class="col-6 col-lg-3">
                <div class="card border-0 bg-primary bg-opacity-10 shadow-sm h-100">
                    <div class="card-body text-center py-4">
                        <div class="mb-2">
                            <i class="bi bi-journal-bookmark fs-1 text-primary"></i>
                        </div>
                        <div class="fs-2 fw-bold text-primary">{{ $overview->active_courses ?? 0 }}</div>
                        <div class="fs-8 text-gray-700">Total Kursus Aktif</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card border-0 bg-success bg-opacity-10 shadow-sm h-100">
                    <div class="card-body text-center py-4">
                        <div class="mb-2">
                            <i class="bi bi-people fs-1 text-success"></i>
                        </div>
                        <div class="fs-2 fw-bold text-success">{{ $overview->total_students ?? 0 }}</div>
                        <div class="fs-8 text-gray-700">Total Murid</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card border-0 bg-warning bg-opacity-10 shadow-sm h-100">
                    <div class="card-body text-center py-4">
                        <div class="mb-2">
                            <i class="bi bi-cash-stack fs-1 text-warning"></i>
                        </div>
                        <div class="fs-2 fw-bold text-warning">Rp {{ number_format($overview->total_unpaid,0,0,"." ?? 0) }}</div>
                        <div class="fs-8 text-gray-700">Belum Lunas</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card border-0 bg-info bg-opacity-10 shadow-sm h-100">
                    <div class="card-body text-center py-4">
                        <div class="mb-2">
                            <i class="bi bi-calendar fs-1 text-info"></i>
                        </div>
                        <div class="fs-2 fw-bold text-info">{{ $overview->total_unscheduled_sessions }}</div>
                        <div class="fs-8 text-gray-700">Sesi Belum Terjadwal</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Row -->
        <div class="row g-5 mb-7">
            <!-- Kursus Aktif Table -->
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h4 class="card-title fw-bold mb-0">Kursus Aktif</h4>
                        <a href="{{ route('courses.index') }}" class="btn btn-sm btn-light-primary">Lihat Semua</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive rounded-3">
                            <table class="table align-middle border-1 table-row-dashed gy-3 mb-0">
                                <thead class="bg-light-primary">
                                    <tr class="fw-semibold text-gray-700 align-middle">
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($activeCourses->take(5) as $course)
                                        @php
                                            $start = \Carbon\Carbon::parse($course->start_date);
                                            $end = \Carbon\Carbon::parse($course->valid_until);
                                            $now = \Carbon\Carbon::now();
                                            $totalDays = $start->diffInDays($end) ?: 1;
                                            $elapsedDays = $start->diffInDays($now > $end ? $end : $now);
                                            $progress = min(100, round(($elapsedDays / $totalDays) * 100));
                                            $avatars = explode(',', $course->student_avatars ?? '');
                                            $names = explode(',', $course->student_names ?? '');
                                            $t_avatars = explode(',', $course->trainer_avatars ?? '');
                                            $t_names = explode(',', $course->trainer_names ?? '');
                                            $totalSessions = $course->max_sessions ?? 0;
                                            $completeSessions = $course->complete_sessions ?? 0;
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <div class="d-flex align-items-center mb-1">
                                                        <span class="fw-bold text-primary me-2"><a href="{{ route('courses.show', $course->course_id) }}">{{ $course->course_name }}</a></span>
                                                        <span class="badge badge-light-info">{{ ucfirst($course->type) }}</span>
                                                        <span class="bi-calendar-event fs-8 text-gray-500 ms-2 me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="sesi berikutnya : {{$course->next_session_date}}"></span>{{ $completeSessions }}/{{ $totalSessions }}
                                                    </div>
                                                    <div class="fs-8 text-gray-600 mb-1">
                                                        <i class="bi bi-geo-alt"></i> {{ $course->venue_name ?? '-' }}
                                                    </div>
                                                    
                                                    <div class="progress h-6px bg-light-primary" style="height:6px;">
                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="fs-8 text-gray-500 mb-1">
                                                        {{ $start->format('d M') }} - {{ $end->format('d M Y') }}
                                                    </div>
                                                    
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-start">
                                                    <div class="symbol-group symbol-hover mb-1">
                                                        @foreach(array_slice($avatars,0,2) as $idx => $avatar)
                                                            <div class="symbol symbol-30px symbol-circle me-n2" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $names[$idx] ?? '' }}">
                                                                <img alt="img" src="{{ $avatar ? asset('storage/'.$avatar) : asset('assets/media/avatars/default-avatar.png') }}" />
                                                            </div>
                                                        @endforeach
                                                        @if(count($avatars) > 2)
                                                            <div class="symbol symbol-30px symbol-circle bg-light me-n2" data-bs-toggle="tooltip" data-bs-placement="top" title="
                                                                @foreach(array_slice($names,2) as $n){{ $n }}@if(!$loop->last), @endif @endforeach
                                                            ">
                                                                <span class="fs-8 fw-bold text-gray-600">+{{ count($avatars)-2 }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="fs-8 text-gray-600">
                                                        {{ count($avatars) }} Murid
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-start">
                                                    <div class="symbol-group symbol-hover mb-1">
                                                        @foreach(array_slice($t_avatars,0,2) as $idx => $avatar)
                                                            <div class="symbol symbol-30px symbol-circle me-n2" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $t_names[$idx] ?? '' }}">
                                                                <img alt="img" src="{{ $avatar ? asset('storage/'.$avatar) : asset('assets/media/avatars/blank.png') }}" />
                                                            </div>
                                                        @endforeach
                                                        @if(count($t_avatars) > 2)
                                                            <div class="symbol symbol-30px symbol-circle bg-light me-n2" data-bs-toggle="tooltip" data-bs-placement="top" title="
                                                                @foreach(array_slice($t_names,2) as $n){{ $n }}@if(!$loop->last), @endif @endforeach
                                                            ">
                                                                <span class="fs-8 fw-bold text-gray-600">+{{ count($t_avatars)-2 }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="fs-8 text-gray-600">
                                                        @foreach(array_slice($t_names,0,2) as $idx => $n)
                                                            {{ $n }}@if(!$loop->last), @endif
                                                        @endforeach
                                                        @if(count($t_names) > 2)
                                                            , <span data-bs-toggle="tooltip" title="@foreach(array_slice($t_names,2) as $n){{ $n }}@if(!$loop->last), @endif @endforeach">+{{ count($t_names)-2 }} lainnya</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">Tidak ada kursus aktif.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kalender Jadwal Sesi -->
            <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light py-3">
                        <h5 class="card-title mb-0 fw-bold">Kalender Jadwal Sesi</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @forelse($sessionSchedules ?? [] as $session)
                                <li class="list-group-item d-flex align-items-center px-0">
                                    <span class="badge badge-light-primary me-3">{{ \Carbon\Carbon::parse($session->session_date)->format('d M Y') }}</span>
                                    <div>
                                        <div class="fw-bold">{{ $session->course_name }}</div>
                                        <div class="fs-8 text-gray-600">{{ $session->venue_name ?? '-' }}</div>
                                    </div>
                                    <span class="ms-auto badge badge-light-success">{{ ucfirst($session->status) }}</span>
                                </li>
                            @empty
                                <li class="list-group-item text-muted">Tidak ada jadwal sesi.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tooltip Bootstrap --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
</x-default-layout>