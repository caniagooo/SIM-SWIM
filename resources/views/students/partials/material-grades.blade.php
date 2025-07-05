<div class="card card-flush border-0 shadow-sm mb-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-row-dashed table-row-gray-200 align-middle gy-2 mb-0">
                <thead>
                    <tr class="fw-bold text-gray-700 fs-7">
                        <th class="text-center align-middle" style="width: 40px;">#</th>
                        <th class="text-start">Nama Materi</th>
                        <th class="text-start">Nama Kursus</th>
                        <th class="text-start" style="width: 80px;">Nilai</th>
                        <th class="text-start" style="width: 120px;">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($student->gradeScores as $grade)
                    <tr>
                        <td class="text-center text-gray-500 fs-8">{{ $loop->iteration }}</td>
                        <td class="text-start fs-8">{{ $grade->material->name ?? '-' }}</td>
                        <td class="text-start fs-8">{{ $grade->course->name ?? '-' }}</td>
                        <td class="text-start fs-8">{{ $grade->score ?? '-' }}</td>
                        <td class="text-start fs-8">{{ $grade->remarks ?? '-' }}</td>
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