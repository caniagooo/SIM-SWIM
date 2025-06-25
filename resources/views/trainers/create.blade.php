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
                                Tambah Trainer Baru
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

                        <form action="{{ route('trainers.store') }}" method="POST" autocomplete="off">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Tipe Pendaftaran</label>
                                <div class="d-flex gap-4">
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="radio" name="register_type" id="register_new" value="new" checked>
                                        <label class="form-check-label" for="register_new">
                                            Buat User Baru
                                        </label>
                                    </div>
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="radio" name="register_type" id="register_existing" value="existing">
                                        <label class="form-check-label" for="register_existing">
                                            Pilih User Sudah Ada
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Form User Baru -->
                            <div id="form-user-baru">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control form-control-lg" value="{{ old('name') }}" placeholder="Nama lengkap trainer">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control form-control-lg" value="{{ old('email') }}" placeholder="Email aktif">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Tanggal Lahir</label>
                                        <input type="date" name="birth_date" class="form-control form-control-lg" value="{{ old('birth_date') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Jenis Kelamin</label>
                                        <select name="gender" class="form-select form-select-lg">
                                            <option value="">Pilih jenis kelamin</option>
                                            <option value="pria" {{ old('gender') == 'pria' ? 'selected' : '' }}>Pria</option>
                                            <option value="wanita" {{ old('gender') == 'wanita' ? 'selected' : '' }}>Wanita</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">No. HP</label>
                                        <input type="text" name="phone" class="form-control form-control-lg" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Alamat</label>
                                        <input type="text" name="alamat" class="form-control form-control-lg" value="{{ old('alamat') }}" placeholder="Alamat lengkap">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Tipe Trainer</label>
                                        <select name="type" class="form-control form-control-lg" required>
                                            <option value="venue" {{ old('type') == 'venue' ? 'selected' : '' }}>Venue</option>
                                            <option value="club" {{ old('type') == 'club' ? 'selected' : '' }}>Club</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Password</label>
                                        <input type="text" class="form-control form-control-lg" value="Akan digenerate otomatis & dikirim ke email" disabled>
                                        <div class="form-text text-success">Password akan digenerate otomatis dan dikirim ke email user.</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form User Existing -->
                            <div id="form-user-existing" style="display:none;">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Pilih User Trainer</label>
                                    <select name="user_id" class="form-control form-control-lg" id="user_id_select" style="width:100%;">
                                        <option value="">Pilih user...</option>
                                        @foreach ($users as $user)
                                            @if($user->type === 'member')
                                                <option value="{{ $user->id }}"
                                                    data-name="{{ $user->name }}"
                                                    data-birthdate="{{ $user->birth_date ?? '' }}"
                                                    data-gender="{{ $user->gender ?? '' }}"
                                                    data-phone="{{ $user->phone ?? '' }}"
                                                    data-alamat="{{ $user->alamat ?? '' }}">
                                                    {{ $user->name }} ({{ $user->email }})
                                                </option>
                                            @endif
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
                                                <div class="fw-bold fs-5 mb-2" id="existing-user-name"></div>
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
                                                        <div class="d-flex align-items-center">
                                                            <i class="bi bi-geo-fill me-2 text-secondary"></i>
                                                            <span class="text-muted small" id="existing-user-kelurahan"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            function toggleForm() {
                if ($('#register_new').is(':checked')) {
                    $('#form-user-baru').show();
                    $('#form-user-existing').hide();
                    $('#existing-user-info').hide();
                } else {
                    $('#form-user-baru').hide();
                    $('#form-user-existing').show();
                    $('#user_id_select').val('').trigger('change');
                }
            }
            $('input[name="register_type"]').on('change', toggleForm);
            toggleForm();

            $('#user_id_select').select2({
                placeholder: "Pilih user...",
                allowClear: true,
                width: '100%'
            });

            $('#user_id_select').on('change', function() {
                let val = $(this).val();
                if (!val) {
                    $('#existing-user-info').hide();
                    return;
                }
                let selected = $(this).find('option:selected');
                $('#existing-user-name').text(selected.data('name'));
                $('#existing-user-email').text(selected.data('email'));
                $('#existing-user-birthdate').text(selected.data('birthdate') || '-');
                $('#existing-user-gender').text(selected.data('gender') || '-');
                $('#existing-user-phone').text(selected.data('phone') || '-');
                $('#existing-user-alamat').text(selected.data('alamat') || '-');
                $('#existing-user-info').show();
            });
        });
    </script>
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
</x-default-layout>