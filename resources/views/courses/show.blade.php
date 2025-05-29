<x-default-layout>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <!-- Header -->
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="card-title">Course Details</h3>
                <div class="card-toolbar">
                    <a href="{{ route('courses.index') }}" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Back to course list">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                    <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm btn-light-warning" data-bs-toggle="tooltip" title="Edit this course">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                </div>
            </div>

            <!-- Body -->
            <div class="card-body">
                <!-- Tabs -->
                <ul class="nav nav-tabs mb-3" id="courseTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="true">Course Info</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="sessions-tab" data-bs-toggle="tab" data-bs-target="#sessions" type="button" role="tab" aria-controls="sessions" aria-selected="false">Sessions</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button" role="tab" aria-controls="attendance" aria-selected="false">Attendance</button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="courseTabsContent">
                    <!-- Course Info Tab -->
                    <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <h6 class="text-muted">Basic Information</h6>
                                <table class="table table-borderless table-sm">
                                    <tbody>
                                        <tr>
                                            <td><strong>Name:</strong></td>
                                            <td>{{ $course->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Type:</strong></td>
                                            <td><span class="badge bg-info">{{ ucfirst($course->type) }}</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Start Date:</strong></td>
                                            <td>{{ $course->start_date ? $course->start_date->format('d M Y') : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Valid Until:</strong></td>
                                            <td>{{ $course->valid_until ? $course->valid_until->format('d M Y') : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Sessions:</strong></td>
                                            <td>{{ $course->sessions->count() }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Scheduled:</strong></td>
                                            <td>{{ $course->sessions->where('status', 'scheduled')->count() }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Completed:</strong></td>
                                            <td>{{ $course->sessions->where('status', 'completed')->count() }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Unscheduled:</strong></td>
                                            <td>{{ $course->sessions->where('status', 'unscheduled')->count() }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Price:</strong></td>
                                            <td>Rp. {{ number_format($course->price, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Venue:</strong></td>
                                            <td>{{ $course->venue->name ?? 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <h6 class="text-muted">Trainer</h6>
                                @if ($course->trainers->count() > 0)
                                    <ul class="list-group list-group-flush">
                                        @foreach ($course->trainers as $trainer)
                                            <li class="list-group-item">{{ $trainer->user->name }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted">No trainers assigned to this course.</p>
                                @endif

                                <!-- Course Materials -->
                                <h6 class="text-muted mt-4">Materials</h6>
                                @if ($course->materials->count() > 0)
                                    <ul class="list-group list-group-flush">
                                        @foreach ($course->materials as $material)
                                            <li class="list-group-item">{{ $material->name }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted">No materials assigned to this course.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Students Table -->
                        <h6 class="text-muted mt-4">Students</h6>
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Profile Photo</th>
                                    <th>Name</th>
                                    <th>Age Group</th>
                                    <th>Attendance Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($course->students as $student)
                                    <tr>
                                        <td>
                                            <img src="{{ $student->profile_picture }}" alt="Profile Picture" class="img-thumbnail" style="width: 50px;">
                                        </td>
                                        <td>{{ $student->user->name }}</td>
                                        <td>{{ $student->age_group }}</td>
                                        <td>{{ $student->attendances->count() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Sessions Tab -->
                    <div class="tab-pane fade" id="sessions" role="tabpanel" aria-labelledby="sessions-tab">
                        <h6 class="text-muted">Sessions</h6>
                        <a href="{{ route('sessions.create', $course->id) }}" class="btn btn-primary btn-sm mb-3">Add Session</a>
                        @if ($course->sessions && $course->sessions->count() > 0)
                            <table id="sessionsTable" class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($course->sessions as $session)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ \Carbon\Carbon::parse($session->session_date)->translatedFormat('l, d F Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($session->start_time)->format('H : i') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($session->end_time)->format('H : i') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $session->status == 'completed' ? 'success' : ($session->status == 'canceled' ? 'danger' : 'info') }}">
                                                    {{ ucfirst($session->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('attendances.index', $session->id) }}" class="btn btn-info btn-sm">Attendance</a>
                                                <a href="{{ route('sessions.edit', [$course->id, $session->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('sessions.destroy', [$course->id, $session->id]) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-muted">No sessions scheduled.</p>
                        @endif
                    </div>

                    <!-- Attendance Tab -->
                    <div class="tab-pane fade" id="attendance" role="tabpanel" aria-labelledby="attendance-tab">
                        <h6 class="text-muted">Attendance</h6>
                        <p>Attendance data will be displayed here.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tooltip Initialization -->
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Initialize DataTables
        $(document).ready(function() {
            $('#sessionsTable').DataTable();
        });
    </script>
</x-default-layout>