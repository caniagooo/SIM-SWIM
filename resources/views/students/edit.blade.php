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
                    <h3 class="card-title">Edit Murid</h3>
                </div>
                <form action="{{ route('students.update', $student->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label>User</label>
                            <select name="user_id" class="form-control" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ $student->user_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="birth_date" class="form-control" value="{{ $student->birth_date }}" required>
                        </div>
                        <div class="form-group">
                            <label>Kelompok Usia</label>
                            <select name="age_group" class="form-control" required>
                                <option value="balita" {{ $student->age_group == 'balita' ? 'selected' : '' }}>Balita</option>
                                <option value="anak-anak" {{ $student->age_group == 'anak-anak' ? 'selected' : '' }}>Anak-anak</option>
                                <option value="remaja" {{ $student->age_group == 'remaja' ? 'selected' : '' }}>Remaja</option>
                                <option value="dewasa" {{ $student->age_group == 'dewasa' ? 'selected' : '' }}>Dewasa</option>
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