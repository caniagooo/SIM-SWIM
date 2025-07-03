<x-default-layout>
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card card-flush border-0 shadow-sm rounded-4">
                <div class="card-header align-items-center py-5 gap-2 gap-md-5 rounded-top-4">
                    <div class="card-title">
                        <h2 class="fw-bold mb-0">
                            <span class="svg-icon svg-icon-2 me-2">
                                <i class="bi-person-badge"></i>
                            </span>
                            Edit Trainer
                        </h2>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ route('trainers.index') }}" class="btn btn-light-primary btn-sm">
                            <span class="svg-icon svg-icon-2 me-1">
                                <i class="bi-arrow-left"></i>
                            </span>
                            Kembali ke Daftar Trainer
                        </a>
                    </div>
                </div>
                <div class="card-body px-4 py-4">
                    @if ($errors->any())
                        <div class="alert alert-danger mb-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('trainers.update', $trainer->id) }}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="form-label fw-semibold">User</label>
                            <select name="user_id" class="form-control form-control-lg" required id="user_id_select" style="width:100%;" disabled>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        data-name="{{ $user->name }}"
                                        data-birthdate="{{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('d M Y') : '' }}"
                                        data-gender="{{ $user->gender ?? '' }}"
                                        data-phone="{{ $user->phone ?? '' }}"
                                        data-alamat="{{ $user->alamat ?? '' }}"
                                        {{ $trainer->user_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="existing-user-info" class="mb-4" style="display:none;">
                            <div class="card border-0 shadow-sm bg-light-subtle rounded-4">
                                <div class="card-body d-flex align-items-center gap-4 p-3">
                                    <div class="flex-shrink-0">
                                        <span class="avatar avatar-lg rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width:56px;height:56px;">
                                            <i class="bi bi-person-circle fs-1 text-primary"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="row g-2">
                                            <div class="col-12 col-md-6">
                                                <div class="d-flex align-items-center mb-1">
                                                    <i class="bi bi-calendar me-2 text-success"></i>
                                                    <span class="text-muted small" id="existing-user-birthdate"></span>
                                                </div>
                                                <div class="d-flex align-items-center mb-1">
                                                    <i class="bi bi-gender-ambiguous me-2 text-info"></i>
                                                    <span class="text-muted small" id="existing-user-gender"></span>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="d-flex align-items-center mb-1">
                                                    <i class="bi bi-telephone me-2 text-warning"></i>
                                                    <span class="text-muted small" id="existing-user-phone"></span>
                                                </div>
                                                <div class="d-flex align-items-center mb-1">
                                                    <i class="bi bi-geo-alt me-2 text-danger"></i>
                                                    <span class="text-muted small" id="existing-user-alamat"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data trainer -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tanggal Lahir</label>
                                <input type="date" name="birth_date" class="form-control form-control-lg" id="birth_date_input"
                                    value="{{ old('birth_date', $trainer->user->birth_date ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jenis Kelamin</label>
                                <select name="gender" class="form-control form-control-lg">
                                    <option value="">Pilih jenis kelamin</option>
                                    <option value="pria" {{ (old('gender', $trainer->user->gender ?? '') == 'pria') ? 'selected' : '' }}>Pria</option>
                                    <option value="wanita" {{ (old('gender', $trainer->user->gender ?? '') == 'wanita') ? 'selected' : '' }}>Wanita</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">No. HP</label>
                                <input type="text" name="phone" class="form-control form-control-lg"
                                    value="{{ old('phone', $trainer->user->phone ?? '') }}" placeholder="08xxxxxxxxxx">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Alamat</label>
                                <input type="text" name="alamat" class="form-control form-control-lg"
                                    value="{{ old('alamat', $trainer->user->alamat ?? '') }}" placeholder="Alamat lengkap">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tipe Trainer</label>
                                <select name="type" class="form-control form-control-lg" required>
                                    <option value="venue" {{ $trainer->type == 'venue' ? 'selected' : '' }}>Venue</option>
                                    <option value="club" {{ $trainer->type == 'club' ? 'selected' : '' }}>Club</option>
                                </select>
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-end gap-2 border-0 px-0 pb-0 mt-4">
                            <a href="{{ route('trainers.index') }}" class="btn btn-light btn-lg">
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
</div>
</x-default-layout>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/js/trainers-edit.js') }}"></script>
@endpush
<style>
    .form-label { font-size: 0.97rem; }
    .form-select-lg, .form-control-lg { font-size: 0.97rem; }
    .card { border-radius: 1.25rem !important; }
    .btn-lg { font-size: 0.93rem; }
    .fw-semibold { font-weight: 500 !important; }
    .alert-info { font-size: 0.95rem; }
    .rounded-top-4 { border-top-left-radius: 1.25rem !important; border-top-right-radius: 1.25rem !important; }
    @media (max-width: 576px) {
        .card-body, .card-header { padding: 1rem !important; }
        .form-label, .form-select-lg, .form-control-lg { font-size: 0.92rem !important; }
    }
</style>
