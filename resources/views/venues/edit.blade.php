@extends('layout.minimal')

@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            @if ($errors->any())
                <div class="alert alert-danger mb-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card card-flush border-0 shadow-sm rounded-4">
                <div class="card-header py-4">
                    <h3 class="fw-bold mb-0">Edit Venue</h3>
                </div>
                <form action="{{ route('venues.update', $venue->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body py-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Venue</label>
                            <input type="text" name="name" class="form-control form-control-lg" value="{{ old('name', $venue->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kepemilikan</label>
                            <select name="ownership" class="form-select form-select-lg" required>
                                <option value="club" {{ $venue->ownership == 'club' ? 'selected' : '' }}>Milik Klub</option>
                                <option value="third_party" {{ $venue->ownership == 'third_party' ? 'selected' : '' }}>Kerjasama</option>
                                <option value="private" {{ $venue->ownership == 'private' ? 'selected' : '' }}>Pribadi</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Alamat</label>
                            <textarea name="address" class="form-control form-control-lg" required>{{ old('address', $venue->address) }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end gap-2 border-0 px-0 pb-0">
                        <a href="{{ route('venues.index') }}" class="btn btn-light btn-lg">
                            <i class="bi bi-arrow-left"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    .form-label { font-size: 0.97rem; }
    .form-select-lg, .form-control-lg { font-size: 0.97rem; }
    .card { border-radius: 1.25rem !important; }
    .btn-lg { font-size: 0.93rem; }
    .fw-semibold { font-weight: 500 !important; }
    .alert-info { font-size: 0.95rem; }
    @media (max-width: 576px) {
        .card-body, .card-header { padding: 1rem !important; }
        .form-label, .form-select-lg, .form-control-lg { font-size: 0.92rem !important; }
    }
</style>
@endsection