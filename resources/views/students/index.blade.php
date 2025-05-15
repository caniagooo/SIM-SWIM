<x-default-layout>
    
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="container-xxl" id="kt_content_container">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">Manajemen Murid</h3>
                    <div class="card-toolbar">
                        <a href="{{ route('students.create') }}" class="btn btn-primary">Tambah Murid</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Tanggal Lahir</th>
                                <th>Kelompok Usia</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $student->user->name }}</td>
                                <td>{{ $student->user->email }}</td>
                                <td>{{ $student->birth_date }}</td>
                                <td>{{ ucfirst($student->age_group) }}</td>
                                <td>
                                    <a href="{{ route('students.show', $student->id) }}" class="btn btn-info btn-sm">Detail</a>
                                    <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</x-default-layout>