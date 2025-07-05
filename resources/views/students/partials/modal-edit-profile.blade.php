<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" action="{{ route('students.update', $student->id) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title" id="editStudentModalLabel">Edit Profil Murid</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3 text-center">
          <img src="{{ $student->user->profile_photo_path ?? asset('assets/media/avatars/default-avatar.png') }}"
               alt="Avatar" class="symbol symbol-80px symbol-circle border mb-2" width="80" height="80">
          <input type="file" class="form-control form-control-sm mt-2" name="avatar" accept="image/*">
        </div>
        <div class="mb-3">
          <label class="form-label">Nama</label>
          <input type="text" class="form-control" name="name" value="{{ old('name', $student->user->name) }}" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" name="email" value="{{ old('email', $student->user->email) }}" required>
        </div>
        <div class="mb-3">
          <label class="form-label">No. HP</label>
          <input type="text" class="form-control" name="phone_number" value="{{ old('phone_number', $student->user->phone_number) }}">
        </div>
        <div class="mb-3">
          <label class="form-label">Tanggal Lahir</label>
          <input type="date" class="form-control" name="birth_date" value="{{ old('birth_date', $student->user->birth_date ?? $student->birth_date) }}">
        </div>
        <!-- Tambahkan field lain sesuai kebutuhan -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>