<x-default-layout>
<div class="container mt-4 mb-4">
    <div class="card card-flush border-0 shadow-sm">
        <div class="card-header align-items-center py-4 gap-2 gap-md-5 flex-column flex-md-row">
            <div class="card-title">
                <h2 class="fw-bold mb-0 d-flex align-items-center">
                    <span class="svg-icon svg-icon-2 me-2 text-primary">
                        <i class="bi-people"></i>
                    </span>
                    Daftar User
                </h2>
            </div>
            <div class="card-toolbar mt-2 mt-md-0">
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
                    <i class="bi bi-plus-circle"></i> Tambah User
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Search -->
            <div class="mb-4">
                <div class="d-flex align-items-center position-relative">
                    <i class="bi bi-search fs-3 position-absolute ms-4"></i>
                    <input type="text" class="form-control form-control-solid w-250px ps-13" placeholder="Cari user" id="mySearchInput"/>
                </div>
            </div>
            <!-- Table -->
            <div class="table-responsive">
                {{ $dataTable->table(['id' => 'users-table', 'class' => 'table table-row-dashed table-row-gray-200 align-middle gy-2 mb-0']) }}
            </div>
            <!-- Custom Table Footer ala trainers -->
            <div id="users_table_footer" class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-2 px-2 py-1 small">
                <div id="users_table_info" class="text-gray-600"></div>
                <div class="d-flex align-items-center gap-2">
                    <label class="mb-0">Tampil
                        <select id="users_table_length" class="form-select form-select-sm d-inline-block w-auto mx-1" style="min-width: 50px;">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        data
                    </label>
                    <div id="users_table_paginate"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add User -->
    <livewire:user.add-user-modal></livewire:user.add-user-modal>
</div>
@push('styles')
<style>
    .symbol-30px { width: 30px; height: 30px; }
    .fs-8 { font-size: 0.88rem !important; }
    #users_table_footer select { min-width: 50px; }
    #users_table_footer { font-size: 0.93rem; }
    .rounded-pill { border-radius: 2rem !important; }
    .btn-light-warning { background: #fff8dd; color: #ffc700; border: none; }
    .btn-light-warning:hover { background: #ffe082; color: #7a5700; }
    .btn-light-danger { background: #fff5f8; color: #f1416c; border: none; }
    .btn-light-danger:hover { background: #ffe5ea; color: #a8072c; }
    @media (max-width: 576px) {
        .card-body, .card-header { padding: 1rem !important; }
        .table { font-size: 0.92rem; }
        .symbol-30px { width: 28px !important; height: 28px !important; }
        #users_table_footer { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
    }
</style>
@endpush
@push('scripts')
    <script>
        // Mencegah error KTLayoutSearch jika tidak ada elemen search Metronic
        window.KTLayoutSearch = {
            init: function() {}
        };
    </script>
    {!! $dataTable->scripts() !!}
@endpush
</x-default-layout>

