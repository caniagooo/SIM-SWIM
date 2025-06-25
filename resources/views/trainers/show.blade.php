<x-default-layout>
    <div class="container py-3">
        <!-- Header Card -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center p-4">
                <a href="{{ route('trainers.index') }}" class="btn btn-sm btn-light btn-active-light-primary" title="Kembali ke daftar trainer">
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
                        <img src="{{ $trainer->user->profile_picture ?? asset('assets/media/avatars/default-avatar.png') }}"
                             alt="Avatar" class="symbol symbol-80px symbol-circle border mb-3" width="80" height="80">
                        <h5 class="fw-bold mb-1">{{ $trainer->user->name }}</h5>
                        <span class="badge bg-info text-white">{{ ucfirst($trainer->type) }}</span>
                        <div class="mt-2">
                            <span class="text-gray-500 fs-8">Last Login</span>
                            <div class="fw-semibold">
                                {{ $trainer->user->last_login_at ? \Carbon\Carbon::parse($trainer->user->last_login_at)->diffForHumans() : '-' }}
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
                            <div class="fw-semibold">{{ $trainer->user->email }}</div>
                        </div>
                        <div class="mb-2">
                            <span class="text-gray-500 fs-8">No. HP</span>
                            <div class="fw-semibold d-flex align-items-center gap-2">
                                {{ $trainer->user->phone ?? '-' }}
                                @if(!empty($trainer->user->phone))
                                    @php
                                        $waNumber = preg_replace('/[^0-9]/', '', $trainer->user->phone);
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
                            <div class="fw-semibold">
                                {{ $trainer->user->birth_date ? \Carbon\Carbon::parse($trainer->user->birth_date)->format('d-m-Y') : '-' }}
                            </div>
                        </div>
                        <div class="mb-2">
                            <span class="text-gray-500 fs-8">Jenis Kelamin</span>
                            <div class="fw-semibold">{{ ucfirst($trainer->user->gender) ?: '-' }}</div>
                        </div>                        
                    </div>
                </div>
            </div>
            <!-- Kolom Kanan: Statistik & Kursus -->
            <div class="col-12 col-lg-4">
                <div class="card card-flush border-0 shadow-sm h-100">
                    <div class="card-body py-10 px-4">
                        <div class="mb-2">
                            <span class="text-gray-500 fs-8">Alamat</span>
                            <div class="fw-semibold">{{ $trainer->user->alamat ?: '-' }}</div>
                        </div>
                        <div class="mb-2">
                            <span class="text-gray-500 fs-8">Terdaftar Sejak</span>
                            <div class="fw-semibold">{{ \Carbon\Carbon::parse($trainer->user->created_at)->format('d M Y') }}</div>
                        </div>
                        <div class="mb-2">
                            <span class="text-gray-500 fs-8">Total Kursus Diampu</span>
                            <div class="fw-bold">{{ $trainer->courses->count() ?? 0 }}</div>
                        </div>
                        <div class="mb-2">
                            <span class="text-gray-500 fs-8">Total Sesi</span>
                            <div class="fw-bold">
                                {{ $sessions->count() ?? 0 }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-pills nav-pills-custom mb-3" id="trainerTabs" role="tablist">
            <li class="nav-item flex-fill text-center" style="min-width: 110px;">
                <button class="nav-link w-100 py-2 px-1" id="courses-tab" data-bs-toggle="pill" data-bs-target="#courses" type="button" role="tab" aria-controls="courses" aria-selected="false">
                    <i class="bi bi-journal-bookmark me-1"></i> Kursus <i class="badge badge-light-primary text-muted ms-1">{{ $trainer->courses->count() ?? 0 }}</i>
                </button>
            </li>
            <li class="nav-item flex-fill text-center" style="min-width: 110px;">
                <button class="nav-link w-100 py-2 px-1 active" id="sessions-tab" data-bs-toggle="pill" data-bs-target="#sessions" type="button" role="tab" aria-controls="sessions" aria-selected="true">
                    <i class="bi bi-calendar-week me-1"></i> Jadwal Sesi <i class="badge badge-light-primary text-muted ms-1">{{ $sessions->count() }}</i>
                </button>
            </li>

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
        </style>

        <div class="tab-content" id="trainerTabsContent">
            <!-- Jadwal Sesi Tab -->
            <div class="tab-pane fade show active" id="sessions" role="tabpanel">
                <div class="card card-flush border-0 shadow-sm mb-3">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-row-dashed table-row-gray-200 align-middle gy-2 mb-0">
                                <thead>
                                    <tr class="text-center fw-semibold text-gray-600 fs-7">
                                        <th>#</th>
                                        <th>Kursus</th>
                                        <th>Tanggal</th>
                                        <th>Jam</th>
                                        <th>Venue</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @forelse ($sessions as $i => $session)
                                    <tr>
                                        <td class="text-center text-gray-500 fs-8">{{ $i + 1 }}</td>
                                        <td class="fs-8">{{ $session->course_name ?? '-' }}</td>
                                        <td class="fs-8">{{ \Carbon\Carbon::parse($session->session_date)->format('d-m-Y') }}</td>
                                        <td class="fs-8">
                                            {{ $session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('H:i') : '-' }}
                                            -
                                            {{ $session->end_time ? \Carbon\Carbon::parse($session->end_time)->format('H:i') : '-' }}
                                        </td>
                                        <td class="fs-8">{{ $session->venue_name ?? '-' }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-light-{{ $session->status === 'completed' ? 'success' : ($session->status === 'cancelled' ? 'danger' : 'info') }}">
                                                {{ ucfirst($session->status) }}
                                            </span>
                                        </td>
                                    </tr>

                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Belum ada jadwal sesi.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Kursus Diampu Tab -->
            <div class="tab-pane fade" id="courses" role="tabpanel">
                <div class="card card-flush border-0 shadow-sm mb-3">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-row-dashed table-row-gray-200 align-middle gy-2 mb-0">
                                <thead>
                                    <tr class="text-center fw-semibold text-gray-600 fs-7">
                                        <th>#</th>
                                        <th>Nama Kursus</th>
                                        <th>Jumlah Sesi</th>
                                        <th>Venue</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $courses = $trainer->courses ?? collect(); @endphp
                                    @foreach ($courses as $course)
                                    <tr>
                                        <td class="text-center text-gray-500 fs-8">{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#courseDetailModal{{ $course->id }}">
                                                {{ $course->name }}
                                            </a>
                                        </td>
                                        <td class="text-center fs-8">{{ $course->sessions->count() ?? 0 }}</td>
                                        <td class="text-center fs-8">{{ $course->venue->name ?? '-' }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-light-{{ $course->status === 'aktif' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($course->status) }}
                                            </span>
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

        <!-- Modal Detail Kursus -->
        @foreach ($trainer->courses ?? [] as $course)
        <div class="modal fade" id="courseDetailModal{{ $course->id }}" tabindex="-1" aria-labelledby="courseDetailModalLabel{{ $course->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content border-0">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="courseDetailModalLabel{{ $course->id }}">Detail Kursus: {{ $course->name }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Nama Pelatih:</strong> {{ $trainer->user->name }}</p>
                        <p><strong>Venue:</strong> {{ $course->venue->name ?? '-' }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($course->status) }}</p>
                        <p><strong>Jumlah Sesi:</strong> {{ $course->sessions->count() ?? 0 }}</p>
                        <p><strong>Jumlah Siswa:</strong> {{ $course->students->count() ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</x-default-layout>