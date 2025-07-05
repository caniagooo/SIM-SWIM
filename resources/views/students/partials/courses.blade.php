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
                                <a href="{{ route('courses.show', $course->id) }}" class="text-primary">
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