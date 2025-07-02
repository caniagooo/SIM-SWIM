@extends('layout.minimal')

@section('title', 'Users')

@section('breadcrumbs')
    {{ Breadcrumbs::render('user-management.users.index') }}
@endsection

@section('content')
<div class="container mt-4 mb-4">
    <div class="card card-flush">
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
                    <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Cari user" id="mySearchInput"/>
                </div>
            </div>
            <!-- Table -->
            <div class="table-responsive">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>

    <!-- Modal Add User -->
    <livewire:user.add-user-modal></livewire:user.add-user-modal>
</div>
@endsection

@push('scripts')
        {{ $dataTable->scripts() }}
        <script>
            document.getElementById('mySearchInput').addEventListener('keyup', function () {
                window.LaravelDataTables['users-table'].search(this.value).draw();
            });
            document.addEventListener('livewire:init', function () {
                Livewire.on('success', function () {
                    $('#kt_modal_add_user').modal('hide');
                    window.LaravelDataTables['users-table'].ajax.reload();
                });
            });
            $('#kt_modal_add_user').on('hidden.bs.modal', function () {
                Livewire.dispatch('new_user');
            });
        </script>
    @endpush