<x-default-layout>


<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container-xxl" id="kt_content_container">
        <div class="card card-custom">
            <div class="card-header">
                <h3 class="card-title">Manajemen Venue</h3>
                <div class="card-toolbar">
                    <a href="{{ route('venues.create') }}" class="btn btn-primary">Tambah Venue</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Kepemilikan</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($venues as $venue)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $venue->name }}</td>
                            <td>{{ ucfirst($venue->ownership) }}</td>
                            <td>{{ $venue->address }}</td>
                            <td>
                                <a href="{{ route('venues.edit', $venue->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('venues.destroy', $venue->id) }}" method="POST" style="display:inline;">
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