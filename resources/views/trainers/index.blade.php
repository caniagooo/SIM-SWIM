<x-default-layout>
    <div class="container py-3">
        <!-- Header Card ala Metronic -->
        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 p-4">
                <div>
                    <h4 class="mb-1 fw-bold text-gray-900">
                        Manajemen Trainer
                    </h4>
                    <div class="d-flex flex-wrap gap-2 small mb-1">
                        <span class="badge badge-light-info fw-semibold">
                            <i class="bi bi-person-badge me-1"></i> Total: {{ $trainers->count() }} Trainer
                        </span>
                    </div>
                </div>
                <div>
                    <a href="{{ route('trainers.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle"></i> Tambah Trainer
                    </a>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Filter & Search -->
        <div class="row g-2 mb-4">
            <div class="col-12 col-md-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" id="search-input" class="form-control form-control-sm" placeholder="Cari trainer...">
                </div>
            </div>
            <div class="col-8 col-md-4">
                <select id="filter-type" class="form-select form-select-sm">
                    <option value="">Semua Tipe</option>
                    @foreach ($trainers->pluck('type')->unique() as $type)
                        <option value="{{ ucfirst($type) }}">{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-4 col-md-2">
                <button id="clear-filter" class="btn btn-light-danger btn-sm w-100">
                    <i class="bi bi-x"></i> Reset
                </button>
            </div>
        </div>

        <div class="col-12">
            <div class="px-5 py-5 card card-flush border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="trainers_table" class="table table-row-dashed table-row-gray-200 align-middle gy-2 mb-0">
                            <thead>
                                <tr class="text-center fw-semibold text-gray-600 fs-7">
                                    <th>Profile</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trainers as $trainer)
                                <tr>
                                    <!-- Profile Picture & Nama -->
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="{{ $trainer->user->profile_picture ?? asset('assets/media/avatars/default-avatar.png') }}" alt="Avatar" class="symbol symbol-30px symbol-circle">
                                            <div>
                                                <div class="fw-semibold text-gray-800">{{ $trainer->user->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-start fs-8">{{ $trainer->user->email }}</td>
                                    <td class="text-start">
                                        <div class="d-flex justify-content-start gap-1">
                                            <a href="{{ route('trainers.show', $trainer->id) }}" class="btn btn-icon btn-sm btn-light-info" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('trainers.edit', $trainer->id) }}" class="btn btn-icon btn-sm btn-light-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('trainers.destroy', $trainer->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-icon btn-sm btn-light-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus trainer ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Compact Footer -->
                    <div id="trainers_table_footer" class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-2 px-2 py-1 small">
                        <div id="trainers_table_info" class="text-gray-600"></div>
                        <div class="d-flex align-items-center gap-2">
                            <label class="mb-0">Tampil
                                <select id="trainers_table_length" class="form-select form-select-sm d-inline-block w-auto mx-1" style="min-width: 50px;">
                                    <option value="5">5</option>
                                    <option value="10" selected>10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                                data
                            </label>
                            <div id="trainers_table_paginate"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .symbol-30px { width: 30px; height: 30px; }
        .fs-8 { font-size: 0.88rem !important; }
        #trainers_table_footer select { min-width: 50px; }
        #trainers_table_footer { font-size: 0.93rem; }
        .rounded-pill { border-radius: 2rem !important; }
        .btn-light-warning { background: #fff8dd; color: #ffc700; border: none; }
        .btn-light-warning:hover { background: #ffe082; color: #7a5700; }
        .btn-light-danger { background: #fff5f8; color: #f1416c; border: none; }
        .btn-light-danger:hover { background: #ffe5ea; color: #a8072c; }
        @media (max-width: 576px) {
            .card-body, .card-header { padding: 1rem !important; }
            .table { font-size: 0.92rem; }
            .symbol-30px { width: 28px !important; height: 28px !important; }
            #trainers_table_footer { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
        }
    </style>
    <script>
        $(document).ready(function() {
            var table = $('#trainers_table').DataTable({
                responsive: true,
                paging: true,
                searching: true,
                pageLength: 10,
                lengthChange: false,
                info: false,
                language: {
                    search: "Cari:",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Berikutnya"
                    }
                },
                dom: 't'
            });

            function updateInfo() {
                var pageInfo = table.page.info();
                $('#trainers_table_info').text(
                    'Menampilkan ' + (pageInfo.start + 1) + ' - ' + pageInfo.end + ' dari ' + pageInfo.recordsDisplay + ' data'
                );
            }
            table.on('draw', updateInfo);
            updateInfo();

            function updatePagination() {
                var pageInfo = table.page.info();
                var html = '';
                if (pageInfo.pages > 1) {
                    html += '<nav><ul class="pagination pagination-sm mb-0">';
                    html += '<li class="page-item' + (pageInfo.page === 0 ? ' disabled' : '') + '"><a class="page-link" href="#" data-page="' + (pageInfo.page - 1) + '">&laquo;</a></li>';
                    for (var i = 0; i < pageInfo.pages; i++) {
                        html += '<li class="page-item' + (i === pageInfo.page ? ' active' : '') + '"><a class="page-link" href="#" data-page="' + i + '">' + (i + 1) + '</a></li>';
                    }
                    html += '<li class="page-item' + (pageInfo.page === pageInfo.pages - 1 ? ' disabled' : '') + '"><a class="page-link" href="#" data-page="' + (pageInfo.page + 1) + '">&raquo;</a></li>';
                    html += '</ul></nav>';
                }
                $('#trainers_table_paginate').html(html);
            }
            table.on('draw', updatePagination);
            updatePagination();

            $('#trainers_table_footer').on('click', '.page-link', function(e) {
                e.preventDefault();
                var page = parseInt($(this).data('page'));
                if (!isNaN(page)) {
                    table.page(page).draw('page');
                }
            });

            $('#trainers_table_length').on('change', function() {
                table.page.len($(this).val()).draw();
            });

            $('#search-input').on('keyup', function() {
                table.search(this.value).draw();
            });

            $('#filter-type').on('change', function() {
                table.column(2).search(this.value).draw();
            });

            $('#clear-filter').on('click', function() {
                $('#filter-type').val('');
                table.column(2).search('').draw();
                $('#search-input').val('');
                table.search('').draw();
            });
        });
    </script>
</x-default-layout>