@extends('layout.minimal')

@section('title')
    Roles
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('user-management.roles.index') }}
@endsection

@section('content')
<!--begin::Content container-->
<div id="kt_app_content_container" class="app-container container-xxl">
    <div class="card card-flush border-0 shadow-sm mb-6">
        <div class="card-header py-5">
            <div class="card-title">
                <h2 class="mb-0 fw-bold">Daftar Roles</h2>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Role
                </button>
            </div>
        </div>
        <div class="card-body">
            <livewire:permission.role-list></livewire:permission.role-list>
        </div>
    </div>
</div>
<!--end::Content container-->

<!--begin::Modal-->
<livewire:permission.role-modal></livewire:permission.role-modal>
<!--end::Modal-->
@endsection
