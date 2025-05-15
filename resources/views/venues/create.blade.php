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
                    <h3 class="card-title">Tambah Venue</h3>
                </div>
                <form action="{{ route('venues.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama Venue</label>
                            <input type="text" name="name" class="form-control" placeholder="Masukkan nama venue" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Kepemilikan</label>
                            <select name="ownership" class="form-control" required>
                                <option value="club" {{ old('ownership') == 'club' ? 'selected' : '' }}>Milik Klub</option>
                                <option value="third_party" {{ old('ownership') == 'third_party' ? 'selected' : '' }}>Kerjasama</option>
                                <option value="private" {{ old('ownership') == 'private' ? 'selected' : '' }}>Pribadi</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="address" class="form-control" placeholder="Masukkan alamat" required>{{ old('address') }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('venues.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</x-default-layout>