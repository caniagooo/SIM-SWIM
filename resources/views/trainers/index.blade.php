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
                    <h3 class="card-title">Manajemen Trainer</h3>
                    <div class="card-toolbar">
                        <a href="{{ route('trainers.create') }}" class="btn btn-primary">Tambah Trainer</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Tipe</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trainers as $trainer)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $trainer->user->name }}</td>
                                <td>{{ $trainer->user->email }}</td>
                                <td>{{ ucfirst($trainer->type) }}</td>
                                <td>
                                    <a href="{{ route('trainers.edit', $trainer->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('trainers.destroy', $trainer->id) }}" method="POST" style="display:inline;">
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