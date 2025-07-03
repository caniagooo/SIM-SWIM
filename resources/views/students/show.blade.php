<x-default-layout>
<div class="container py-3">
    <!-- Header Card -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center p-4">
            <a href="{{ route('students.index') }}" class="btn btn-sm btn-light btn-active-light-primary" title="Kembali ke daftar murid">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Info Grid -->
    <div class="row g-3 mb-4">
        <!-- Kolom Kiri: Foto & Nama -->
        <div class="col-12 col-md-4 col-lg-3">
            <div class="card card-flush border-0 shadow-sm h-100 text-center">
                <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
                    <img src="{{ $student->user->profile_photo_path ?? asset('assets/media/avatars/default-avatar.png') }}"
                         alt="Avatar" class="symbol symbol-80px symbol-circle border mb-3" width="80" height="80">
                    <h5 class="fw-bold mb-1">{{ $student->user->name }}</h5>
                    <div class="mt-2">
                        <span class="text-gray-500 fs-8">Last Login</span>
                        <div class="fw-semibold">
                            {{ $student->user->last_login_at ? \Carbon\Carbon::parse($student->user->last_login_at)->diffForHumans() : '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kolom Tengah: Informasi Pribadi -->
        <div class="col-12 col-md-8 col-lg-5">
            <div class="card card-flush border-0 shadow-sm h-100">
                <div class="card-body py-10 px-4">
                    <div class="mb-2">
                        <span class="text-gray-500 fs-8">Email</span>
                        <div class="fw-semibold">{{ $student->user->email }}</div>
                    </div>
                    <div class="mb-2">
                        <span class="text-gray-500 fs-8">No. HP</span>
                        <div class="fw-semibold d-flex align-items-center gap-2">
                            {{ $student->user->phone_number ?? '-' }}
                            @if(!empty($student->user->phone_number))
                                @php
                                    $waNumber = preg_replace('/[^0-9]/', '', $student->user->phone_number);
                                    if (substr($waNumber, 0, 1) === '0') {
                                        $waNumber = '62' . substr($waNumber, 1);
                                    }
                                @endphp
                                <a href="https://wa.me/{{ $waNumber }}" target="_blank" class="btn btn-sm btn-icon btn-success" title="Chat WhatsApp">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="mb-2">
                        <span class="text-gray-500 fs-8">Tanggal Lahir</span>
                        <div class="fw-semibold">{{ \Carbon\Carbon::parse($student->birth_date)->format('d-m-Y') }}</div>
                    </div>
                    <div>
                        <span class="text-gray-500 fs-8">Usia</span>
                        <div class="fw-semibold">{{ \Carbon\Carbon::parse($student->birth_date)->age }} tahun</div>
                    </div>
                    <div class="mt-3">
                        <span class="text-gray-500 fs-8">Terdaftar Sejak</span>
                        <div class="fw-semibold">{{ \Carbon\Carbon::parse($student->user->created_at)->format('d M Y') }}</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Kolom Kanan: Informasi Kursus -->
        <div class="col-12 col-lg-4">
            <div class="card card-flush border-0 shadow-sm h-100">
                <div class="card-body py-10 px-4">
                    <div class="mb-2">
                        <span class="text-gray-500 fs-8">Total Kursus</span>
                        <div class="fw-bold">{{ $student->courses_count }}</div>
                    </div>
                    <div class="mb-2">
                        <span class="text-gray-500 fs-8">Total Sesi</span>
                        <div class="fw-bold">{{ $student->sessions_count }}</div>
                    </div>
                    <div class="mb-2">
                        <span class="text-gray-500 fs-8">Nilai Kumulatif</span>
                        <div class="fw-bold">-</div>
                    </div>
                    <div class="mb-2">
                        <span class="text-gray-500 fs-8">Rata-rata Nilai</span>
                        <div class="fw-bold">-</div>
                    </div>
                    <div class="mt-3">
                        <span class="text-gray-500 fs-8">Progress</span>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" style="width: 60%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-pills nav-pills-custom mb-3" id="studentTabs" role="tablist">
        @php
            $activeTab = request()->get('tab', 'courses');
            $tabList = [
                'courses' => ['icon' => 'bi-journal-bookmark', 'label' => 'Kursus'],
                'materials' => ['icon' => 'bi-book', 'label' => 'Materi & Nilai'],
                'analytics' => ['icon' => 'bi-bar-chart-line', 'label' => 'Analitik'],
            ];
        @endphp
        @foreach($tabList as $tabKey => $tab)
            <li class="nav-item flex-fill text-center" role="presentation" style="min-width: 110px;">
                <button
                    class="nav-link w-100 py-2 px-1 {{ $activeTab === $tabKey ? 'active' : '' }}"
                    id="{{ $tabKey }}-tab"
                    data-bs-toggle="pill"
                    data-bs-target="#{{ $tabKey }}"
                    type="button"
                    role="tab"
                    aria-controls="{{ $tabKey }}"
                    aria-selected="{{ $activeTab === $tabKey ? 'true' : 'false' }}"
                    tabindex="{{ $activeTab === $tabKey ? '0' : '-1' }}"
                    style="font-size: 1rem; font-weight: 500; border: none; background: none;"
                >
                    <i class="bi {{ $tab['icon'] }} me-1"></i> {{ $tab['label'] }}
                </button>
            </li>
        @endforeach
    </ul>
    <style>
        .nav-pills-custom {
            background: #f5f8fa;
            border-radius: 0.5rem;
            overflow: hidden;
            border: 1px solid #e4e6ef;
            margin-bottom: 1rem;
        }
        .nav-pills-custom .nav-link {
            border-radius: 0;
            font-weight: 500;
            color: #5e6278;
            transition: background 0.2s, color 0.2s, border-bottom 0.2s;
            border: none;
            background: none;
            padding: 0.85rem 0.5rem;
            font-size: 1rem;
            position: relative;
        }
        .nav-pills-custom .nav-link.active,
        .nav-pills-custom .nav-link:focus,
        .nav-pills-custom .nav-link:hover {
            background: #fff !important;
            color: #009ef7 !important;
            border-bottom: 2.5px solid #009ef7;
            z-index: 2;
        }
        .nav-pills-custom .nav-link:not(.active):hover {
            background: #f1faff !important;
            color: #009ef7 !important;
        }
        .nav-pills-custom .nav-link i {
            font-size: 1.1em;
            vertical-align: middle;
            margin-right: 0.25em;
        }
        .nav-pills-custom .nav-link.active i {
            color: #009ef7;
        }
        .nav-pills-custom .nav-link:disabled {
            color: #b5b5c3 !important;
            background: none !important;
            cursor: not-allowed;
        }
        @media (max-width: 576px) {
            .nav-pills-custom .nav-link {
                font-size: 0.95rem;
                padding: .5rem .1rem;
            }
            .card-body, .card-header { padding: 1rem !important; }
            .table { font-size: 0.92rem; }
            .symbol-60px { width: 48px !important; height: 48px !important; }
        }
        .symbol-60px { width: 60px; height: 60px; }
        .fs-7 { font-size: 0.95rem !important; }
        .fs-8 { font-size: 0.88rem !important; }
        .table th, .table td { vertical-align: middle !important; }
        .table th { text-align: center !important; }
        .table td { font-size: 0.95rem; }
        .badge { font-size: 0.93rem; }
    </style>

    <div class="tab-content" id="studentTabsContent">
        <!-- Kursus Tab -->
        <div class="tab-pane fade show active" id="courses" role="tabpanel">
            <div class="card card-flush border-0 shadow-sm mb-3">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-200 align-middle gy-2 mb-0">
                            <thead>
                                <tr class="fw-bold text-gray-700 fs-7 text-center align-middle">
                                    <th class="text-center align-middle" style="width: 40px;">#</th>
                                    <th class="text-start align-middle">Nama Kursus</th>
                                    <th class="text-center align-middle" style="width: 100px;">Jumlah Sesi</th>
                                    <th class="text-center align-middle" style="width: 120px;">Venue</th>
                                    <th class="text-center align-middle" style="width: 100px;">Status</th>
                                    <th class="text-center align-middle" style="width: 120px;">Nilai Kumulatif</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($student->courses as $course)
                                <tr>
                                    <td class="text-center text-gray-500 fs-8">{{ $loop->iteration }}</td>
                                    <td class="text-start align-middle">
                                        <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#courseDetailModal{{ $course->id }}">
                                            {{ $course->name }}
                                        </a>
                                    </td>
                                    <td class="text-center fs-8">{{ $course->max_sessions }}</td>
                                    <td class="text-center fs-8">{{ $course->venue->name ?? '-' }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-light-{{ $course->status === 'aktif' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($course->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center fs-8">-</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted fs-8">Belum ada kursus.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Materi & Nilai Tab -->
        <div class="tab-pane fade" id="materials" role="tabpanel">
            <div class="card card-flush border-0 shadow-sm mb-3">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-200 align-middle gy-2 mb-0">
                            <thead>
                                <tr class="fw-bold text-gray-700 fs-7 text-center align-middle">
                                    <th class="text-center align-middle" style="width: 40px;">#</th>
                                    <th class="text-start align-middle">Nama Materi</th>
                                    <th class="text-start align-middle">Nama Kursus</th>
                                    <th class="text-center align-middle" style="width: 120px;">Tanggal Penilaian</th>
                                    <th class="text-center align-middle" style="width: 80px;">Nilai</th>
                                    <th class="text-center align-middle" style="width: 120px;">Nama Pelatih</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($student->grades as $grade)
                                <tr>
                                    <td class="text-center text-gray-500 fs-8">{{ $loop->iteration }}</td>
                                    <td class="text-start fs-8">{{ $grade->material->name ?? '-' }}</td>
                                    <td class="text-start fs-8">{{ $grade->course->name ?? '-' }}</td>
                                    <td class="text-center fs-8">{{ $grade->created_at ? $grade->created_at->format('Y-m-d') : '-' }}</td>
                                    <td class="text-center fs-8">{{ $grade->score ?? '-' }}</td>
                                    <td class="text-center fs-8">{{ $grade->trainer->user->name ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted fs-8">Belum ada penilaian materi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Analitik Tab -->
        <div class="tab-pane fade" id="analytics" role="tabpanel">
            <div class="card card-flush border-0 shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="mb-3">Timeline Sesi Latihan</h5>
                    <div id="chart-timeline" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>
</x-default-layout>
    <!-- Modal Detail Kursus -->
    @foreach ($student->courses->take(5) as $course)
    <div class="modal fade" id="courseDetailModal{{ $course->id }}" tabindex="-1" aria-labelledby="courseDetailModalLabel{{ $course->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="courseDetailModalLabel{{ $course->id }}">Detail Kursus: {{ $course->name }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nama Pelatih:</strong> {{ $course->coach_name ?? '-' }}</p>
                    <p><strong>Venue:</strong> {{ $course->venue->name ?? '-' }}</p>
                    <p><strong>Status:</strong> {{ $course->status }}</p>
                    <p><strong>Jumlah Sesi:</strong> {{ $course->max_sessions }}</p>
                    <p><strong>Nilai Kumulatif:</strong> -</p>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>