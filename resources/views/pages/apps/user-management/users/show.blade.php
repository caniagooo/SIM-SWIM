@extends('layout.minimal')

@section('title', 'Detail User')

@section('breadcrumbs')
    {{ Breadcrumbs::render('user-management.users.show', $user) }}
@endsection

@section('content')
<div class="container mt-4 mb-4">
    <div class="card card-flush">
        <div class="card-header align-items-center py-4 gap-2 gap-md-5 flex-column flex-md-row">
            <div class="card-title">
                <h2 class="fw-bold mb-0 d-flex align-items-center">
                    <span class="svg-icon svg-icon-2 me-2 text-primary">
                        <i class="bi-person"></i>
                    </span>
                    Detail User
                </h2>
            </div>
            <div class="card-toolbar mt-2 mt-md-0">
                <a href="{{ route('user-management.users.index') }}" class="btn btn-light-primary btn-sm">
                    <span class="svg-icon svg-icon-2 me-1">
                        <i class="bi-arrow-left"></i>
                    </span>
                    Kembali ke Daftar User
                </a>
                <a href="{{ route('user-management.users.edit', $user->id) }}" class="btn btn-primary btn-sm ms-2">
                    <i class="bi bi-pencil"></i> Edit User
                </a>
            </div>
        </div>
        <div class="card-body">            
            <div class="card card-flush border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mt-4 mb-4 fw-bold">Informasi Akun</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center mb-4">
                <div class="col-auto">
                    <div class="symbol symbol-100px symbol-circle">
                        @if($user->profile_photo_url)
                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                        @else
                            <div class="symbol-label fs-1 bg-light-primary text-primary">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col">
                    <h3 class="fw-bold mb-1">{{ $user->name }}</h3>
                    <div class="mb-2">
                        @foreach($user->roles as $role)
                            <span class="badge badge-light-primary me-1">{{ ucwords($role->name) }}</span>
                        @endforeach
                    </div>
                    <div class="mb-2">
                        <i class="bi bi-envelope me-1"></i>
                        <span class="text-muted">{{ $user->email }}</span>
                    </div>
                    @if(!empty($user->phone))
                    <div class="mb-2">
                        <i class="bi bi-telephone me-1"></i>
                        <span class="text-muted">{{ $user->phone }}</span>
                    </div>
                    @endif
                    @if(!empty($user->address))
                    <div class="mb-2">
                        <i class="bi bi-geo-alt me-1"></i>
                        <span class="text-muted">{{ $user->address }}</span>
                    </div>
                    @endif
                </div>
            </div>
                    <table class="table table-borderless mb-0">
                        <tr>
                            <th class="w-40">ID User</th>
                            <td>{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td>
                                @foreach($user->roles as $role)
                                    <span class="badge badge-light-primary me-1">{{ ucwords($role->name) }}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($user->is_active ?? true)
                                    <span class="badge badge-light-success">Aktif</span>
                                @else
                                    <span class="badge badge-light-danger">Tidak Aktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>{{ $user->created_at ? $user->created_at->format('d M Y H:i') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Update Terakhir</th>
                            <td>{{ $user->updated_at ? $user->updated_at->format('d M Y H:i') : '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .symbol-100px { width: 100px; height: 100px; }
    .symbol-label { display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; }
    .bg-light-primary { background: #f1faff !important; }
    .bg-light-info { background: #f8fafd !important; }
    .bg-light-warning { background: #fff8dd !important; }
    .bg-light-success { background: #e8fff3 !important; }
    .fw-semibold { font-weight: 600 !important; }
    .table th { width: 160px; }
    @media (max-width: 576px) {
        .symbol-100px { width: 70px !important; height: 70px !important; }
        .card-body, .card-header { padding: 1rem !important; }
        .table { font-size: 0.92rem; }
    }
</style>
@endpush
