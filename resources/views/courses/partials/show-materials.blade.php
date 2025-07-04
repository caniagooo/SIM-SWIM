<div class="row justify-content-center">
    <div class="col-12">
        <div class="card card-flush border-0 shadow-sm">
            <div class="card-body px-4 py-4">
                <div class="mb-3">
                    <div class="fw-semibold mb-1">Basic Skills:</div>
                    @if(count($basicSkills))
                        <ul class="mb-2">
                            @foreach($basicSkills as $skill)
                                <li>{{ $skill }}</li>
                            @endforeach
                        </ul>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </div>

                <div class="mb-3">
                    <div class="fw-semibold mb-1">Ringkasan Materi:</div>
                    <div class="d-flex flex-wrap gap-3">
                        <span class="badge badge-light-info">Total Materi: {{ $materials->count() }}</span>
                        <span class="badge badge-light-primary">Estimasi Sesi: {{ $totalEstimatedSessions }}</span>
                        <span class="badge badge-light-success">Rata-rata Nilai Minimum: {{ $averageMinScore }}</span>
                    </div>
                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Materi</th>
                                <th>Estimasi Sesi</th>
                                <th>Nilai Minimum</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($materials as $i => $material)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td>{{ $material->name }}</td>
                                    <td>{{ $material->estimated_sessions }}</td>
                                    <td>{{ $material->minimum_score }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada materi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>