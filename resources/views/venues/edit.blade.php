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
                    <h3 class="card-title">Edit Venue</h3>
                </div>
                <form action="{{ route('venues.update', $venue->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama Venue</label>
                            <input type="text" name="name" class="form-control" value="{{ $venue->name }}" required>
                        </div>
                        <div class="form-group">
                            <label>Kepemilikan</label>
                            <select name="ownership" class="form-control" required>
                                <option value="club" {{ $venue->ownership == 'club' ? 'selected' : '' }}>Milik Klub</option>
                                <option value="third_party" {{ $venue->ownership == 'third_party' ? 'selected' : '' }}>Kerjasama</option>
                                <option value="private" {{ $venue->ownership == 'private' ? 'selected' : '' }}>Pribadi</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="address" class="form-control" required>{{ $venue->address }}</textarea>
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