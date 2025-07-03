<x-default-layout>
    <div class="container mt-4 mb-4">
        <div class="card card-flush border-0 shadow-sm">
            <div class="card-header py-4 px-4 d-flex flex-wrap align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-4 flex-wrap">
                    <div class="symbol symbol-70px symbol-circle flex-shrink-0">
                        @if($user->profile_photo_path)
                            <img src="{{ $user->profile_photo_path }}" alt="{{ $user->name }}">
                        @else
                            <div class="symbol-label bg-light-primary text-primary fs-2 fw-bold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <div class="fw-bold fs-4 mb-1">{{ $user->name }}</div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            @if($user->is_active ?? true)
                                <span class="badge badge-light-success fw-normal">Aktif</span>
                            @else
                                <span class="badge badge-light-danger fw-normal">Tidak Aktif</span>
                            @endif
                        </div>
                        <div class="text-gray-600 small mb-1">
                            <i class="bi bi-hash"></i> ID: {{ $user->id }}
                        </div>
                        <div class="text-gray-600 small">
                            <i class="bi bi-clock-history"></i> Dibuat: {{ $user->created_at ? $user->created_at->format('d M Y H:i') : '-' }}
                        </div>
                    </div>
                </div>
                <div class="mt-3 mt-md-0 d-flex gap-2">
                    <a href="{{ route('user-management.users.index') }}" class="btn btn-light-primary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#kt_modal_update_details">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                </div>
            </div>
            <div class="card-body py-4 px-4">
                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <table class="table table-borderless table-sm mb-0 align-middle">
                            <tr>
                                <th class="text-gray-600 w-150px">Email</th>
                                <td><i class="bi bi-envelope me-1"></i>{{ $user->email }}</td>
                            </tr>
                            @if($user->phone)
                            <tr>
                                <th class="text-gray-600">Nomor HP</th>
                                <td><i class="bi bi-telephone me-1"></i>{{ $user->phone }}</td>
                            </tr>
                            @endif
                            @if($user->gender)
                            <tr>
                                <th class="text-gray-600">Jenis Kelamin</th>
                                <td><i class="bi bi-gender-ambiguous me-1"></i>{{ ucfirst($user->gender) }}</td>
                            </tr>
                            @endif
                            @if($user->birth_date)
                            <tr>
                                <th class="text-gray-600">Tanggal Lahir</th>
                                <td><i class="bi bi-calendar me-1"></i>{{ \Carbon\Carbon::parse($user->birth_date)->format('d M Y') }}</td>
                            </tr>
                            @endif
                            @if($user->alamat)
                            <tr>
                                <th class="text-gray-600">Alamat</th>
                                <td>{{ $user->alamat }}</td>
                            </tr>
                            @endif
                            @if($user->kelurahan_id)
                            <tr>
                                <th class="text-gray-600">Kelurahan ID</th>
                                <td>{{ $user->kelurahan_id }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    <div class="col-12 col-md-6">
                        <table class="table table-borderless table-sm mb-0 align-middle">
                            <tr>
                                <th class="text-gray-600 w-150px">Tipe User</th>
                                <td>
                                    <span class="badge badge-light-secondary">{{ ucfirst($user->type) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-gray-600">Role</th>
                                <td>
                                    @foreach($user->roles as $role)
                                        <span class="badge badge-light-primary">{{ ucwords($role->name) }}</span>
                                    @endforeach
                                </td>
                            </tr>
                            @if($user->last_login_at)
                            <tr>
                                <th class="text-gray-600">Login Terakhir</th>
                                <td>{{ $user->last_login_at }}</td>
                            </tr>
                            @endif
                            @if($user->last_login_ip)
                            <tr>
                                <th class="text-gray-600">IP Login Terakhir</th>
                                <td>{{ $user->last_login_ip }}</td>
                            </tr>
                            @endif
                            <tr>
                                <th class="text-gray-600">Update Terakhir</th>
                                <td>{{ $user->updated_at ? $user->updated_at->format('d M Y H:i') : '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Update User --}}
    @include('pages.apps.user-management.users.modals._update-details', ['user' => $user])
</x-default-layout>
