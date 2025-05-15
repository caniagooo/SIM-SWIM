
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
                    <h3 class="card-title">Tambah Pembayaran</h3>
                </div>
                <form action="{{ route('payments.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Murid</label>
                            <select name="student_id" class="form-control" required>
                                <option value="">Pilih Murid</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kursus</label>
                            <select name="course_id" class="form-control">
                                <option value="">Pilih Kursus (Opsional)</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="number" name="amount" class="form-control" placeholder="Masukkan jumlah pembayaran" required>
                        </div>
                        <div class="form-group">
                            <label>Jenis Pembayaran</label>
                            <select name="type" class="form-control" required>
                                <option value="prepaid">Prepaid</option>
                                <option value="regular">Regular</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Pembayaran</label>
                            <input type="date" name="payment_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('payments.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</x-default-layout>