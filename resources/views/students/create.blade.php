<x-default-layout>

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="container-xxl" id="kt_content_container">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">Tambah Murid</h3>
                </div>
                <form action="{{ route('students.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>User</label>
                            <select name="user_id" class="form-control" required>
                                <option value="">Pilih User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="birth_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Kelompok Usia</label>
                            <select name="age_group" class="form-control" required>
                                <option value="balita">Balita</option>
                                <option value="anak-anak">Anak-anak</option>
                                <option value="remaja">Remaja</option>
                                <option value="dewasa">Dewasa</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('students.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</x-default-layout>