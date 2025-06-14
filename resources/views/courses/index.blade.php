<x-default-layout>
    <div class="container">
        <!-- Header -->
        <div class="d-flex flex-wrap flex-stack mb-6">
            <div class="d-flex align-items-center">
                <h1 class="fw-bold mb-0 me-4">Courses</h1>
                <span class="badge badge-light-primary fs-6">{{ $courses->count() }} Total</span>
            </div>
            <a href="{{ route('courses.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Course
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-6" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Course Cards -->
        <div class="row g-8">
            @forelse ($courses as $course)
                @php
                    $payment = $course->payment;
                    $sessionsCompleted = $course->sessions->where('status', 'completed')->count();
                    $totalSessions = $course->max_sessions;
                    $isExpired = now()->greaterThan($course->valid_until);
                    $now = now();
                    $start = $course->start_date;
                    $end = $course->valid_until;
                    $progress = $now->lt($start) ? 0 : ($now->gt($end) ? 100 : round($now->diffInDays($start, false) >= 0 ? ($now->diffInDays($start) / max(1, $end->diffInDays($start))) * 100 : 0));
                    $isGroup = $course->type === 'group';
                @endphp
                <div class="col-xl-4 col-md-6">
                    <div class="card card-flush shadow-sm h-100 border-0 rounded-4 overflow-hidden">
                        <!-- Card Header -->
                        <div class="card-header bg-white py-4 px-10 border-0 shadow-sm position-relative">
                            <div class="d-flex justify-content-between align-items-center gap-5">
                                <!-- Avatar Murid -->
                                <div class="d-flex align-items-center">
                                    @php
                                        $students = $course->students->take(2);
                                    @endphp
                                    @foreach($students as $student)
                                        <img src="{{ $student->user->profile_photo_path ?? asset('assets/media/avatars/default-avatar.png') }}"
                                             alt="{{ $student->user->name }}"
                                             class="rounded-circle border border-2 border-white shadow"
                                             style="width: 40px; height: 40px; object-fit: cover; margin-left: -10px; background: #f1f1f1;">
                                    @endforeach
                                    @if($course->students->count() > 2)
                                        <span class="rounded-circle bg-light d-flex align-items-center justify-content-center border border-2 border-white shadow"
                                              style="width: 40px; height: 40px; margin-left: -10px; font-size: 0.95rem;">
                                            +{{ $course->students->count() - 2 }}
                                        </span>
                                    @endif
                                </div>
                                <div class="flex-grow-1 d-flex flex-column justify-content-center">
                                    <!-- Nama Murid di atas nama kursus -->
                                    @if($course->students->count() > 1)
                                        <span class="badge badge-light-info mb-1" style="width: fit-content;">
                                            {{ $course->students->count() }} murid
                                        </span>
                                    @elseif($course->students->count() === 1)
                                        <span class="fw-semibold text-gray-800 mb-1" style="font-size: 1rem;">
                                            {{ $course->students->first()->user->name }}
                                        </span>
                                    @else
                                        <span class="text-muted mb-1" style="font-size: 1rem;">-</span>
                                    @endif
                                    <div class="text-muted text-lowercase fw-semibold" style="font-size: 0.8rem;">
                                        {{ $course->name }}
                                    </div>
                                </div>
                                <!-- Status Kursus di kanan -->
                                @php
                                    $isActive = false;
                                    $statusText = '';
                                    $statusClass = '';
                                    $now = now();
                                    $expired = $now->greaterThan($course->valid_until);
                                    $maxSessionReached = $course->max_session ? ($sessionsCompleted >= $course->max_session) : false;

                                    if ($payment && $payment->status === 'paid' && !$expired && !$maxSessionReached) {
                                        $isActive = true;
                                        $statusText = 'Aktif';
                                        $statusClass = 'badge badge-light-success';
                                    } elseif ($expired || $maxSessionReached) {
                                        $statusText = 'Expired';
                                        $statusClass = 'badge badge-light-danger';
                                    } else {
                                        $statusText = 'Unpaid';
                                        $statusClass = '';
                                    }
                                @endphp
                                <div class="ms-auto d-flex align-items-center">
                                    @if($statusText === 'Unpaid')
                                        <button type="button"
                                            class="btn btn-sm btn-light-warning btnPayNow"
                                            data-course-id="{{ $course->id }}"
                                            style="padding: 2px 10px; font-size: 0.85rem;">
                                            <i class="bi bi-cash-coin"></i> Pay Now
                                        </button>
                                    @else
                                        <span class="{{ $statusClass }}" style="font-size: 0.95rem; padding: 6px 14px;">
                                            {{ $statusText }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body py-6 px-6">
                            <div class="d-flex flex-column gap-3">
                                <!-- Pelatih -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-semibold text-gray-700"><i class="bi bi-person-badge me-1"></i> Pelatih</span>
                                    <span class="ms-2 text-end">
                                        @if($course->trainers->count())
                                            @foreach($course->trainers as $trainer)
                                                <span class="d-inline-flex align-items-center mb-1 me-1">
                                                    <img 
                                                        src="{{ $trainer->user->profile_photo_path ?? asset('assets/media/avatars/default-avatar.png') }}" 
                                                        alt="{{ $trainer->user->name }}" 
                                                        class="rounded-circle border border-2 border-white shadow" 
                                                        style="width: 32px; height: 32px; object-fit: cover; background: #f1f1f1; margin-right: 6px;">
                                                    <span class="badge badge-light-success">{{ $trainer->user->name }}</span>
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="text-muted"></span>
                                            <button type="button" class="btn btn-sm btn-light-warning ms-2" data-bs-toggle="modal" data-bs-target="#assignTrainerModal-{{ $course->id }}">
                                                <i class="bi bi-person-plus"></i> Pilih Pelatih
                                            </button>
                                        @endif
                                    </span>
                                </div>
                                <!-- Materi -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-semibold text-gray-700">
                                        <i class="bi bi-journal-text me-1"></i> Materi
                                    </span>
                                    <span class="ms-2 text-end">
                                        @if($course->materials->isEmpty())
                                            <span class="text-muted"></span>
                                            <button type="button" class="btn btn-sm btn-light-warning ms-2" data-bs-toggle="modal" data-bs-target="#assignMaterialsModal-{{ $course->id }}">
                                                <i class="bi bi-journal-plus"></i> Assign Materi
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-light-success ms-2" data-bs-toggle="modal" data-bs-target="#assignMaterialsModal-{{ $course->id }}">
                                                <i class="bi bi-journal-text"></i>
                                                {{ $course->materials->count() }} Materi
                                            </button>
                                        @endif
                                    </span>
                                </div>
                            </div>                            
                        </div>

                        <!-- Card Footer -->
                        <div class="card-footer bg-white border-0 px-4 pb-1 pt-0">
                            <div class="mt-4">
                                @php
                                    $today = now();
                                    $start = $course->start_date;
                                    $end = $course->valid_until;
                                    $totalDays = $start->diffInDays($end) ?: 1;
                                    $elapsedDays = $start->lte($today) ? $start->diffInDays(min($today, $end)) : 0;
                                    $progress = min(100, max(0, round(($elapsedDays / $totalDays) * 100)));
                                    $daysLeft = $today->lte($end) ? $today->diffInDays($end) : 0;

                                    // Metronic green: #50CD89
                                    // Light green with low opacity: rgba(80,205,137,0.15)
                                    $progressBg = 'background-color: rgba(80,205,137,0.15);';
                                    $progressBarBg = 'background: #50CD89; color: #fff;';
                                @endphp
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div class="flex-grow-1 mx-0" style="min-width: 0;">
                                        <div class="position-relative" style="height: 25px;">
                                            <div class="progress" style="height: 25px; {{ $progressBg }}">
                                                <div class="progress-bar"
                                                     role="progressbar"
                                                     style="width: {{ $progress }}%; {{ $progressBarBg }}"
                                                     aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-between align-items-center px-2" style="pointer-events: none;">
                                                <span class="fs-8 text-white  px-1 rounded-1" style="line-height: 1;">{{ $course->start_date->format('d M') }}</span>
                                                <span class="fs-8 text-muted  px-1 rounded-1" style="line-height: 1;">{{ $course->valid_until->format('d M') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- card lower footer -->
                        <div class="d-flex flex-column gap-3 py-6 px-6">  
                            <!--badge informasi sesi (total sesi, completed) -->
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge badge-light-primary me-2">
                                    <i class="bi bi-calendar me-1"></i>
                                    {{ $totalSessions }} Sesi
                                </span>
                                <span class="badge badge-light-success">
                                    <i class="bi bi-check2-circle me-1"></i>
                                    {{ $sessionsCompleted }} Completed
                                </span>
                                @php                                        
                                $scheduledSessions = $course->sessions->where('status', 'scheduled');
                                @endphp
                                <span class="badge badge-light-warning">
                                    <i class="bi bi-calendar-range me-1"></i>
                                    {{ $scheduledSessions->count() }} scheduled
                                </span>
                            </div>                
                        </div>
                    </div>
                </div>
                @push('scripts')
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
                            new bootstrap.Tooltip(tooltipTriggerEl)
                        })
                    });
                </script>
                @endpush

                <!-- Assign Trainer Modal -->
                <div class="modal fade" id="assignTrainerModal-{{ $course->id }}" tabindex="-1" aria-labelledby="assignTrainerModalLabel-{{ $course->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('courses.assign', $course->id) }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="assignTrainerModalLabel-{{ $course->id }}">Assign Trainer</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="trainers" class="form-label">Trainer</label>
                                        <select name="trainers[]" class="form-select" multiple>
                                            @foreach ($allTrainers as $trainer)
                                                <option value="{{ $trainer->id }}" {{ $course->trainers->contains($trainer->id) ? 'selected' : '' }}>
                                                    {{ $trainer->user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Assign Materials Modal -->
                <div class="modal fade" id="assignMaterialsModal-{{ $course->id }}" tabindex="-1" aria-labelledby="assignMaterialsModalLabel-{{ $course->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="{{ route('courses.assign', $course->id) }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="assignMaterialsModalLabel-{{ $course->id }}">Pilih Materi Kursus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="col-12 mb-4">
                                        <div class="fs-6">
                                            <div class="fw-bold">Catatan terkait murid:</div>
                                        </div>
                                        <i class="fs-6">{{ $course->basic_skills ?: '-' }}</i>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Pilih Materi:</strong></label>
                                        <div class="accordion accordion-icon-toggle" id="materialsAccordion-{{ $course->id }}">
                                            @php
                                                $groupedMaterials = $allMaterials->groupBy('level');
                                                $selectedMaterialIds = $course->materials->pluck('id')->toArray();
                                            @endphp
                                            @foreach ($groupedMaterials as $level => $materials)
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="heading-{{ $course->id }}-{{ $level }}">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $course->id }}-{{ $level }}" aria-expanded="false" aria-controls="collapse-{{ $course->id }}-{{ $level }}">
                                                            <span class="fw-bold">Level {{ $level }}</span>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse-{{ $course->id }}-{{ $level }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $course->id }}-{{ $level }}" data-bs-parent="#materialsAccordion-{{ $course->id }}">
                                                        <div class="accordion-body p-0">
                                                            <div class="list-group list-group-flush">
                                                                @foreach ($materials as $material)
                                                                    <label class="list-group-item d-flex align-items-center py-3 px-3" style="border-bottom: 1px solid #f1f1f1;">
                                                                        <input 
                                                                            type="checkbox" 
                                                                            name="materials[]" 
                                                                            value="{{ $material->id }}" 
                                                                            class="form-check-input material-checkbox-{{ $course->id }} me-3 ms-1"
                                                                            style="margin-left: 0.5rem; margin-right: 1rem;"
                                                                            data-estimasi="{{ $material->estimated_sessions }}"
                                                                            data-minscore="{{ $material->minimum_score }}"
                                                                            {{ in_array($material->id, $selectedMaterialIds) ? 'checked' : '' }}
                                                                        >
                                                                        <div class="flex-grow-1">
                                                                            <div class="fw-semibold fs-6 mb-1">{{ $material->name }}</div>
                                                                            <div class="d-flex flex-wrap gap-3 small text-muted">
                                                                                <span><i class="bi bi-clock me-1"></i> Estimasi: <span class="fw-bold">{{ $material->estimated_sessions }}</span> sesi</span>
                                                                                <span><i class="bi bi-star me-1"></i> Min. Skor: <span class="fw-bold">{{ $material->minimum_score }}</span></span>
                                                                            </div>
                                                                        </div>
                                                                    </label>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="border-top pt-3 mt-3">
                                        <div class="row text-center">
                                            <div class="col">
                                                <div class="fw-bold fs-6">Materi Terpilih</div>
                                                <div id="selectedCount-{{ $course->id }}" class="fs-5">0</div>
                                            </div>
                                            <div class="col">
                                                <div class="fw-bold fs-6">Total Estimasi Sesi</div>
                                                <div id="totalSessions-{{ $course->id }}" class="fs-5">0</div>
                                            </div>
                                            <div class="col">
                                                <div class="fw-bold fs-6">Rata-rata Min. Skor</div>
                                                <div id="avgMinScore-{{ $course->id }}" class="fs-5">0</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @push('scripts')
                <script>
                document.addEventListener('DOMContentLoaded', function () {
                    function updateMaterialStats(courseId) {
                        let checkboxes = document.querySelectorAll('.material-checkbox-' + courseId);
                        let selected = 0, totalSessions = 0, totalMinScore = 0;
                        checkboxes.forEach(cb => {
                            if (cb.checked) {
                                selected++;
                                totalSessions += parseInt(cb.getAttribute('data-estimasi')) || 0;
                                totalMinScore += parseFloat(cb.getAttribute('data-minscore')) || 0;
                            }
                        });
                        document.getElementById('selectedCount-' + courseId).textContent = selected;
                        document.getElementById('totalSessions-' + courseId).textContent = totalSessions;
                        document.getElementById('avgMinScore-' + courseId).textContent = selected ? (totalMinScore / selected).toFixed(2) : 0;
                    }

                    @foreach ($courses as $course)
                        updateMaterialStats({{ $course->id }});
                        document.querySelectorAll('.material-checkbox-{{ $course->id }}').forEach(cb => {
                            cb.addEventListener('change', function () {
                                updateMaterialStats({{ $course->id }});
                            });
                        });
                    @endforeach
                });
                </script>
                @endpush

                <!-- Invoice Modal (dummy, sesuaikan dengan kebutuhan Anda) -->
                <div class="modal fade" id="invoiceModal-{{ $course->id }}" tabindex="-1" aria-labelledby="invoiceModalLabel-{{ $course->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="invoiceModalLabel-{{ $course->id }}">Invoice</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-2"><strong>Invoice Number:</strong> {{ $payment->invoice_number ?? '-' }}</div>
                                <div class="mb-2"><strong>Amount:</strong> Rp. {{ number_format($payment->amount ?? 0) }}</div>
                                <div class="mb-2"><strong>Status:</strong> {{ ucfirst($payment->status ?? '-') }}</div>
                                <div class="mb-2"><strong>Payment Method:</strong> {{ ucfirst($payment->payment_method ?? '-') }}</div>
                                <div class="mb-2"><strong>Course:</strong> {{ $course->name }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">
                    <div class="alert alert-info py-10">
                        <i class="bi bi-info-circle fs-2x mb-2"></i>
                        <div class="fs-5">No courses available.</div>
                    </div>
                </div>
            @endforelse
        </>
    </div>

    <!-- Pay Now Modal (global, isi invoice & konfirmasi) -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Payment Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="paymentModalBody">
                    <!-- Akan diisi via JS -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmPaymentButton">Confirm</button>
                </div>
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let courseId = null;
    let invoiceNumber = null;

    // Pay Now button
    document.querySelectorAll('.btnPayNow').forEach(button => {
        button.addEventListener('click', function () {
            courseId = this.getAttribute('data-course-id');
            // Fetch invoice data via AJAX (atau bisa langsung render di blade jika ingin)
            fetch(`/course-payments/invoice/${courseId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('paymentModalBody').innerHTML = `
                        <div class="mb-2"><strong>Invoice Number:</strong> ${data.invoice_number}</div>
                        <div class="mb-2"><strong>Amount:</strong> Rp. ${data.amount.toLocaleString()}</div>
                        <div class="mb-2"><strong>Status:</strong> ${data.status}</div>
                        <div class="mb-3">
                            <label for="actualPaymentMethod" class="form-label">Payment Method</label>
                            <select id="actualPaymentMethod" class="form-select">
                                <option value="cash">Cash</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="credit_card">Credit Card</option>
                            </select>
                        </div>
                    `;
                    const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
                    modal.show();
                });
        });
    });

    // Invoice button
    document.querySelectorAll('.btnInvoice').forEach(button => {
        button.addEventListener('click', function () {
            invoiceNumber = this.getAttribute('data-invoice');
            const modal = new bootstrap.Modal(document.getElementById('invoiceModal-' + invoiceNumber.split('-').pop()));
            modal.show();
        });
    });

    // Confirm Payment
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
            location.reload();
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