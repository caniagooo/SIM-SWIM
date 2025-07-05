@extends('layout.student')
@section('content')
<div class="container py-3">
    <!-- Header Card -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center p-4">
            <div>
                <div class="fs-5 fw-bold mb-1">{{ $student->user->name }}</div>
                <div class="text-muted small">{{ $student->user->email }}</div>
            </div>
            <span class="badge bg-light-primary text-primary fw-normal">Murid</span>
        </div>
    </div>

    <!-- Info Grid -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm text-center">
                <div class="card-body py-3">
                    <div class="fs-3 fw-bold text-primary">{{ $student->courses ? $student->courses->count() : 0 }}</div>
                    <div class="text-muted small">Total Kursus</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm text-center">
                <div class="card-body py-3">
                    <div class="fs-3 fw-bold text-success">{{ $student->sessions_count ?? '-' }}</div>
                    <div class="text-muted small">Total Sesi</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm text-center">
                <div class="card-body py-3">
                    <div class="fs-3 fw-bold text-info">{{ $student->gradeScores ? $student->gradeScores->count() : 0 }}</div>
                    <div class="text-muted small">Materi Dinilai</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card h-100 border-0 shadow-sm text-center">
                <div class="card-body py-3">
                    <div class="fs-3 fw-bold text-warning">
                        {{ $student->cumulative_score !== null ? number_format($student->cumulative_score, 2) : '-' }}
                    </div>
                    <div class="text-muted small">Nilai Kumulatif</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Riwayat -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-bold fs-6 p-0">
            <ul class="nav nav-tabs nav-justified" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ $tab === 'materi' ? 'active' : '' }}"
                       href="?tab=materi&materi_page=1">Nilai Materi</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ $tab === 'sesi' ? 'active' : '' }}"
                       href="?tab=sesi&sesi_page=1">Jadwal Sesi</a>
                </li>
            </ul>
        </div>
        <div class="card-body p-0">
            <div class="tab-content">
                <!-- Tab Nilai Materi -->
                <div class="tab-pane fade {{ $tab === 'materi' ? 'show active' : '' }}">
                    <div class="table-responsive">
                        <table class="table table-sm table-row-dashed mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center" style="width:40px;">#</th>
                                    <th>Materi</th>
                                    <th>Kursus</th>
                                    <th>Nilai</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($materiData as $i => $grade)
                                <tr>
                                    <td class="text-center text-muted">{{ ($materiPage-1)*$materiPerPage + $i + 1 }}</td>
                                    <td>{{ $grade->material->name ?? '-' }}</td>
                                    <td>{{ $grade->course->name ?? '-' }}</td>
                                    <td class="fw-semibold">{{ $grade->score ?? '-' }}</td>
                                    <td>{{ $grade->created_at ? \Carbon\Carbon::parse($grade->created_at)->format('d-m-Y') : '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada nilai materi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination Materi -->
                    @if($materiTotal > $materiPerPage)
                    <nav class="mt-2">
                        <ul class="pagination pagination-sm justify-content-end mb-0">
                            @for($p=1; $p <= ceil($materiTotal/$materiPerPage); $p++)
                                <li class="page-item {{ $materiPage == $p ? 'active' : '' }}">
                                    <a class="page-link"
                                       href="?tab=materi&materi_page={{ $p }}">{{ $p }}</a>
                                </li>
                            @endfor
                        </ul>
                    </nav>
                    @endif
                </div>
                <!-- Tab Jadwal Sesi -->
                <div class="tab-pane fade {{ $tab === 'sesi' ? 'show active' : '' }}">
                    <div class="table-responsive">
                        <table class="table table-sm table-row-dashed mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center" style="width:40px;">#</th>
                                    <th>Kursus</th>
                                    <th>Nama Sesi</th>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(($sesiData ?? []) as $i => $item)
                                <tr>
                                    <td class="text-center text-muted">{{ ($sesiPage-1)*$sesiPerPage + $i + 1 }}</td>
                                    <td>{{ $item['course']->name ?? '-' }}</td>
                                    <td>{{ $item['session']->name ?? '-' }}</td>
                                    <td>
                                        {{ $item['session']->date ? \Carbon\Carbon::parse($item['session']->date)->format('d-m-Y') : '-' }}
                                    </td>
                                    <td>
                                        {{ $item['session']->start_time ? \Carbon\Carbon::parse($item['session']->start_time)->format('H:i') : '-' }}
                                        @if($item['session']->end_time)
                                            - {{ \Carbon\Carbon::parse($item['session']->end_time)->format('H:i') }}
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada jadwal sesi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination Sesi -->
                    @if($sesiTotal > $sesiPerPage)
                    <nav class="mt-2">
                        <ul class="pagination pagination-sm justify-content-end mb-0">
                            @for($p=1; $p <= ceil($sesiTotal/$sesiPerPage); $p++)
                                <li class="page-item {{ $sesiPage == $p ? 'active' : '' }}">
                                    <a class="page-link"
                                       href="?tab=sesi&sesi_page={{ $p }}">{{ $p }}</a>
                                </li>
                            @endfor
                        </ul>
                    </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection