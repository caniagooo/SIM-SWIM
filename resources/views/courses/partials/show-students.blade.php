<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $i => $student)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>
                        <img src="{{ $student->user->profile_photo_path ?? asset('assets/media/avatars/default-avatar.png') }}"
                             alt="Avatar" class="symbol symbol-30px symbol-circle me-2" width="28" height="28">
                        {{ $student->user->name }}
                    </td>
                    <td>{{ $student->user->email }}</td>
                    <td>
                        <button type="button"
                                class="btn btn-sm btn-light-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#scoreStudentModal-{{ $student->id }}">
                            <i class="bi bi-clipboard-check"></i> Nilai
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Belum ada peserta.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>