<x-default-layout>
    <div class="container">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Courses</h1>
            <a href="{{ route('courses.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Course
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Course Cards -->
        <div class="row">
            @forelse ($courses as $course)
                @php
                    $payment = $course->payment; // Relasi pembayaran kursus
                    $sessionsCompleted = $course->sessions->where('status', 'completed')->count();
                    $totalSessions = $course->sessions->count();
                    $isExpired = now()->greaterThan($course->valid_until);
                @endphp
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">{{ $course->name }}</h5>
                        </div>
                        <div class="card-body">
                            <!-- Tipe Kursus -->
                            <p>
                                <strong>Type:</strong> 
                                <span class="badge bg-info" data-bs-toggle="tooltip" title="{{ $course->students->pluck('name')->join(', ') }}">
                                    {{ ucfirst($course->type) }}
                                </span>
                            </p>

                            <!-- Tanggal Mulai dan Selesai -->
                            <p>
                                <strong>Start Date:</strong> {{ $course->start_date->format('d M Y') }} <br>
                                <strong>End Date:</strong> 
                                <span class="badge bg-{{ $isExpired ? 'danger' : 'success' }}">
                                    {{ $course->valid_until->format('d M Y') }} ({{ $isExpired ? 'Expired' : 'Active' }})
                                </span>
                            </p>

                            <!-- Sesi -->
                            <p>
                                <strong>Sessions:</strong> {{ $sessionsCompleted }} / {{ $totalSessions }}
                            </p>

                            <!-- Pelatih -->
                            <p>
                                <strong>Trainer:</strong> {{ $course->trainers->pluck('name')->join(', ') }}
                            </p>

                            <!-- Venue -->
                            <p>
                                <strong>Venue:</strong> {{ $course->venue->name ?? 'N/A' }}
                            </p>

                            <!-- Biaya Kursus -->
                            <p>
                                <strong>Price:</strong> Rp. {{ number_format($course->price) }} <br>
                                <span class="badge bg-{{ $payment->status === 'paid' ? 'success' : ($payment->status === 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($payment->status ?? 'Not Paid') }}
                                </span>
                            </p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="{{ route('courses.show', $course->id) }}" class="btn btn-sm btn-primary">View</a>
                            <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            @if ($payment && $payment->status === 'pending')
                                <button type="button" class="btn btn-sm btn-success btnPayNow" data-course-id="{{ $course->id }}">Pay Now</button>
                            @endif
                            <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">
                    <p>No courses available.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Modal untuk Konfirmasi Pembayaran -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Payment Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Please select the actual payment method:</p>
                    <div class="mb-3">
                        <label for="actualPaymentMethod" class="form-label">Payment Method</label>
                        <select id="actualPaymentMethod" class="form-select">
                            <option value="cash">Cash</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="credit_card">Credit Card</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmPaymentButton">Confirm</button>
                </div>
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let courseId = null;

    // Event listener untuk tombol Pay Now
    document.querySelectorAll('.btnPayNow').forEach(button => {
        button.addEventListener('click', function () {
            courseId = this.getAttribute('data-course-id');
            const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
            modal.show();
        });
    });

    // Event listener untuk tombol Confirm Payment
    document.getElementById('confirmPaymentButton').addEventListener('click', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const actualPaymentMethod = document.getElementById('actualPaymentMethod').value;

        fetch(`/course-payments/process/${courseId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ payment_method: actualPaymentMethod }),
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            location.reload(); // Reload halaman untuk memuat status pembayaran terbaru
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while processing the payment.');
        });

        const modal = bootstrap.Modal.getInstance(document.getElementById('paymentModal'));
        modal.hide();
    });
});
</script>

</x-default-layout>