
<x-default-layout>
    
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="container-xxl" id="kt_content_container">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">Edit Trainer</h3>
                </div>
                <form action="{{ route('trainers.update', $trainer->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label>User</label>
                            <select name="user_id" class="form-control" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ $trainer->user_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tipe Trainer</label>
                            <select name="type" class="form-control" required>
                                <option value="venue" {{ $trainer->type == 'venue' ? 'selected' : '' }}>Venue</option>
                                <option value="club" {{ $trainer->type == 'club' ? 'selected' : '' }}>Club</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('trainers.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</x-default-layout>